<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exhibition;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Mail;

class ExhibitionPaymentController extends Controller
{
    public function handleNotification(Request $request)
    {
        $notif = $request->all();
        $orderId = $notif['order_id'] ?? null;
        $transactionStatus = $notif['transaction_status'] ?? null;
        $paymentType = $notif['payment_type'] ?? null;
        $fraudStatus = $notif['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['error' => 'Order ID tidak ditemukan'], 400);
        }

        $ticket = \App\Models\Ticket::where('order_id', $orderId)->first();
        if (!$ticket) {
            return response()->json(['error' => 'Tiket tidak ditemukan'], 404);
        }

        // Update status berdasarkan notifikasi Midtrans
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $ticket->status = 'paid';
            $ticket->save();

            // Kirim email e-ticket
            Mail::to($ticket->email)->send(new \App\Mail\BookingConfirmationMail($ticket));
        } elseif ($transactionStatus === 'pending') {
            $ticket->status = 'pending';
            $ticket->save();
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $ticket->status = 'failed';
            $ticket->save();
        }

        return response()->json(['message' => 'Notifikasi diproses']);
    }

    public function getSnapToken(Request $request, $id)
    {
        try {
            $exhibition = Exhibition::findOrFail($id);
            $sessionUser = session('auth_user');

            if (!$sessionUser || !isset($sessionUser['id'])) {
                return response()->json(['message' => 'User belum login.'], 401);
            }

            $user = \App\Models\User::find($sessionUser['id']);
            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan.'], 401);
            }

            // Cek tiket duplikat
            $existing = \App\Models\Ticket::where('user_id', $user->id)
                ->where('exhibition_id', $exhibition->id)
                ->orderByDesc('created_at')
                ->first();

            // Jika sudah ada tiket, redirect ke My Tickets
            if ($existing) {
                 return response()->json([
                    'status' => 'success',
                    'redirect_url' => route('user.tickets')
                ]);
            }

            // Buat Tiket baru (Free)
            $orderId = 'EXH-' . strtoupper(uniqid());
            
            $ticket = \App\Models\Ticket::create([
                'user_id' => $user->id,
                'exhibition_id' => $exhibition->id,
                'order_id' => $orderId,
                'email' => $user->email,
                'phone' => $user->whatsapp ?? '-', // Fallback
                'payment_method' => 'free',
                'status' => 'paid', // Langsung paid
                'snap_token' => null
            ]);

            // Kirim Email Konfirmasi
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\TicketConfirmationMail($ticket));
            } catch (\Exception $e) {
                \Log::error('Exhibition Email Error: ' . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'redirect_url' => route('user.tickets')
            ]);

        } catch (\Exception $e) {
            \Log::error('Exhibition Ticket Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal memproses tiket: ' . $e->getMessage()
            ], 500);
        }
    }
}
