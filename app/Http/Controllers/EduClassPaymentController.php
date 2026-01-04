<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationalProgram;
use App\Models\Booking;
use Midtrans\Snap;
use Midtrans\Config;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Log;

class EduClassPaymentController extends Controller
{
    public function getSnapToken(Request $request, $id)
    {
        // DEBUG LOGGING
        \Log::info("EduClassPaymentController: getSnapToken called for ID: $id");
        try {
            file_put_contents(storage_path('app/debug_pay.txt'), "Entered getSnapToken for ID: $id\n", FILE_APPEND);
        } catch(\Exception $e) {}

        try {
            $sessionUser = session('auth_user');
            if (!$sessionUser || !isset($sessionUser['id'])) {
                return response()->json(['message' => 'User belum login.'], 401);
            }
            $user = \App\Models\User::find($sessionUser['id']);
            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan.'], 401);
            }
            $edu = EducationalProgram::findOrFail($id);
            if (!$edu->type || !$edu->is_active) {
                return response()->json(['message' => 'Program tidak valid.'], 422);
            }
            $price = $edu->price;
            if (is_null($price)) $price = 0;
            if ($price <= 0) {
                return response()->json(['message' => 'Harga program belum diisi. Silakan hubungi admin.'], 422);
            }
            // Cek booking existing
            $existing = Booking::where('user_id', $user->id)
                ->where('bookable_type', EducationalProgram::class)
                ->where('bookable_id', $edu->id)
                ->orderByDesc('created_at')
                ->first();
            if ($existing) {
                if ($existing->payment_status === 'paid') {
                    return response()->json(['message' => 'Anda sudah terdaftar di program ini.'], 400);
                }
                // Jika pending, generate token baru (jangan pakai cache token lama yg mungkin expired)
                // if ($existing->payment_status === 'pending' && $existing->snap_token) {
                //    return response()->json(['token' => $existing->snap_token]);
                // }
                // Jika pending tapi snap_token kosong, generate baru
                if ($existing->payment_status === 'pending') {
                    $orderId = $existing->booking_code;
                } else {
                // Jika status lain, buat booking baru
                    $orderId = 'EDUCLASS-' . uniqid();
                }
            } else {
                $orderId = 'EDUCLASS-' . uniqid();
            }

            // CRITICAL FIX: If resuming pending payment, ALWAYS regenerate Order ID
            // Midtrans does not allow regenerating Snap Token for the same Order ID if details change or to refresh.
            // We must update the booking_code to a fresh one.
            if ($existing && $existing->payment_status === 'pending') {
                 $orderId = 'EDUCLASS-' . uniqid() . '-R'; // R for Retry
                 // UPDATE the booking code in the database model instance
                 $existing->booking_code = $orderId;
            }

            file_put_contents(public_path('debug_pay.txt'), "Start: " . $orderId . "\n", FILE_APPEND);

            $eventDate = null;
            if (!empty($edu->schedule)) {
                $timestamp = strtotime($edu->schedule);
                if ($timestamp && $timestamp > 0) {
                    $eventDate = date('Y-m-d H:i:s', $timestamp);
                }
            }
            $quantity = $request->input('quantity', 1);
            if ($quantity < 1) $quantity = 1;
            $totalPrice = (int) $price * $quantity;

            // Jika booking belum ada, buat baru
            if (!$existing || ($existing && $existing->payment_status !== 'pending')) {
                file_put_contents(public_path('debug_pay.txt'), "Creating New Booking\n", FILE_APPEND);
                $booking = Booking::create([
                    'user_id' => $user->id,
                    'bookable_type' => EducationalProgram::class,
                    'bookable_id' => $edu->id,
                    'booking_code' => $orderId,
                    'participant_name' => $user->name,
                    'payment_method' => 'midtrans',
                    'payment_status' => 'pending',
                    'status' => 'confirmed',
                    'event_date' => $eventDate,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice, // Add total price
                ]);
            } else {
                file_put_contents(public_path('debug_pay.txt'), "Updating Existing Booking\n", FILE_APPEND);
                $booking = $existing;
                // Update existing booking
                $booking->update([
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'booking_code' => $orderId, // SAVE THE NEW ORDER ID
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalPrice, // Use total price
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => [
                    [
                        'id' => $edu->id,
                        'price' => (int) $price,
                        'quantity' => $quantity,
                        'name' => substr($edu->title, 0, 50), // Midtrans limit
                    ]
                ]
            ];
            
            file_put_contents(public_path('debug_pay.txt'), "Params prepared. Getting Token...\n", FILE_APPEND);

            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;
            $snapToken = Snap::getSnapToken($params);
            
            file_put_contents(public_path('debug_pay.txt'), "Token Generated: " . substr($snapToken, 0, 5) . "...\n", FILE_APPEND);

            // Simpan snap_token ke booking jika belum ada atau berubah
            $booking->snap_token = $snapToken;
            $booking->save(); // Always save new token for recalculated price
            
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            file_put_contents(public_path('debug_pay.txt'), "ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
            \Log::error('Midtrans SnapToken Error (EduClass): ' . $e->getMessage());
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
            ->where('bookable_type', EducationalProgram::class)
            ->with('user')
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
        $booking->update([
            'payment_status' => $paymentStatus,
            'status' => $status,
        ]);
        
        // Send Email if Paid
        if ($paymentStatus === 'paid') {
            try {
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

        return redirect()->route('user.bookings')->with('success', 'Pembayaran berhasil! Silakan cek email Anda.');
    }
    public function unfinish(Request $request)
    {
        return redirect()->route('user.bookings')->with('error', 'Pembayaran dibatalkan.');
    }
    public function error(Request $request)
    {
        return redirect()->route('user.bookings')->with('error', 'Terjadi kesalahan pembayaran.');
    }
}
