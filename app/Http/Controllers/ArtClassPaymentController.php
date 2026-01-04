<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtClass;
use App\Models\Booking;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Log;

class ArtClassPaymentController extends Controller
{
    public function getSnapToken(Request $request, $id)
    {
        try {
            $artClass = ArtClass::findOrFail($id);
            $sessionUser = session('auth_user');
            if (!$sessionUser || !isset($sessionUser['id'])) {
                return response()->json(['message' => 'User belum login.'], 401);
            }
            $user = \App\Models\User::find($sessionUser['id']);
            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan.'], 401);
            }
            if (!$artClass->price || $artClass->price <= 0) {
                return response()->json(['message' => 'Harga kelas tidak valid.'], 422);
            }
            // Cek booking dobel
            $existing = Booking::where('user_id', $user->id)
                ->where('bookable_type', ArtClass::class)
                ->where('bookable_id', $artClass->id)
                ->where('payment_status', 'pending')
                ->orderByDesc('created_at')
                ->first();
            if ($existing && $existing->snap_token) {
                // Jika sudah ada booking pending, balas 200 dan sertakan snap_token
                return response()->json([
                    'status' => 'pending_exists',
                    'token' => $existing->snap_token
                ], 200);
            }
            // Buat booking baru (status pending)
            $orderId = 'ARTCLASS-' . uniqid();
            $eventDate = null;
            if (!empty($artClass->schedule)) {
                $timestamp = strtotime($artClass->schedule);
                if ($timestamp && $timestamp > 0) {
                    $eventDate = date('Y-m-d H:i:s', $timestamp);
                }
            }
            $booking = Booking::create([
                'user_id' => $user->id,
                'bookable_type' => ArtClass::class,
                'bookable_id' => $artClass->id,
                'booking_code' => $orderId,
                'participant_name' => $user->name,
                'payment_method' => 'midtrans',
                'payment_status' => 'pending',
                'status' => 'confirmed', // CHANGED BACK: DB only supports confirmed/cancelled
                'event_date' => $eventDate,
            ]);
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $artClass->price,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;
            $snapToken = Snap::getSnapToken($params);
            // Simpan snap_token ke booking
            $booking->snap_token = $snapToken;
            $booking->save();
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            \Log::error('Midtrans SnapToken Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal membuat token pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        $notif = $request->all();
        $orderId = $notif['order_id'] ?? null;
        $transactionStatus = $notif['transaction_status'] ?? null;
        $paymentType = $notif['payment_type'] ?? null;
        $fraudStatus = $notif['fraud_status'] ?? null;
        if (!$orderId) {
            return response()->json(['message' => 'Order ID tidak ditemukan'], 400);
        }
        $booking = Booking::where('booking_code', $orderId)
            ->where('bookable_type', ArtClass::class)
            ->with('user') // Eager load user
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }
        // Map status Midtrans ke status booking
        $status = 'pending';
        $paymentStatus = 'pending';
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $status = 'confirmed';
            $paymentStatus = 'paid';
        } elseif ($transactionStatus === 'pending') {
            $status = 'pending';
            $paymentStatus = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $status = 'canceled';
            $paymentStatus = 'failed';
        }
        
        // Update booking
        $booking->update([
            'payment_status' => $paymentStatus,
            'status' => $status,
        ]);

        // Send Email if Paid
        if ($paymentStatus === 'paid') {
            try {
                // Determine email: booking->email (if exists) or user->email
                $recipientEmail = $booking->user ? $booking->user->email : null;
                
                if ($recipientEmail) {
                    Mail::to($recipientEmail)->send(new BookingConfirmationMail($booking));
                    Log::info("Booking Confirmation Email sent to: " . $recipientEmail);
                }
            } catch (\Exception $e) {
                Log::error("Failed to send booking confirmation email: " . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Notifikasi diproses']);
    }

    public function finish(Request $request)
    {
        // Localhost Fix: Capture params from frontend redirect and force update if valid
        $orderId = $request->query('order_id');
        $status = $request->query('status');
        
        if ($orderId && ($status == 'success' || $status == 'settlement' || $status == 'capture')) {
             // Simulate notification for localhost
             $simulatedRequest = new Request([
                 'order_id' => $orderId,
                 'transaction_status' => 'settlement',
                 'payment_type' => 'credit_card',
                 'fraud_status' => 'accept'
             ]);
             // Call handleNotification internally
             $this->handleNotification($simulatedRequest);
        }

        // Redirect ke halaman sukses booking
        return redirect()->route('user.bookings')->with('success', 'Pembayaran berhasil! Silakan cek email Anda.');
    }

    public function unfinish(Request $request)
    {
        // Redirect ke halaman gagal/cancel
        return redirect()->route('user.bookings')->with('error', 'Pembayaran dibatalkan.');
    }

    public function error(Request $request)
    {
        // Redirect ke halaman error
        return redirect()->route('user.bookings')->with('error', 'Terjadi kesalahan pembayaran.');
    }
}
