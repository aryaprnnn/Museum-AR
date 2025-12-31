<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationalProgram;
use App\Models\Booking;
use Midtrans\Snap;
use Midtrans\Config;

class EduClassPaymentController extends Controller
{
    public function getSnapToken(Request $request, $id)
    {
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
                // Jika pending, kembalikan snap_token jika ada
                if ($existing->payment_status === 'pending' && $existing->snap_token) {
                    return response()->json(['token' => $existing->snap_token]);
                }
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
            $eventDate = null;
            if (!empty($edu->schedule)) {
                $timestamp = strtotime($edu->schedule);
                if ($timestamp && $timestamp > 0) {
                    $eventDate = date('Y-m-d H:i:s', $timestamp);
                }
            }
            // Jika booking belum ada, buat baru
            if (!$existing || ($existing && $existing->payment_status !== 'pending')) {
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
                ]);
            } else {
                $booking = $existing;
            }
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $price,
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
            // Simpan snap_token ke booking jika belum ada
            if (!$booking->snap_token) {
                $booking->snap_token = $snapToken;
                $booking->save();
            }
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
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
            ->first();
        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }
        // Map status Midtrans ke status booking
        $status = 'confirmed';
        $paymentStatus = 'pending';
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $status = 'confirmed';
            $paymentStatus = 'paid';
        } elseif ($transactionStatus === 'pending') {
            $status = 'confirmed'; // keep as confirmed, payment still pending
            $paymentStatus = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $status = 'cancelled';
            $paymentStatus = 'failed';
        }
        $booking->update([
            'payment_status' => $paymentStatus,
            'status' => $status,
        ]);
        return response()->json(['message' => 'Notifikasi diproses']);
    }

    public function finish(Request $request)
    {
        return redirect()->route('user.bookings')->with('success', 'Pembayaran berhasil!');
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
