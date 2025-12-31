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
        $exhibition = Exhibition::findOrFail($id);
        $email = $request->input('email');
        $phone = $request->input('phone');
        if(!$email || !$phone) {
            return response()->json(['error' => 'Email dan nomor HP wajib diisi'], 422);
        }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;

        $orderId = 'EXH-' . $exhibition->id . '-' . time();
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => 50000, // ganti dengan harga tiket sebenarnya
            ],
            'customer_details' => [
                'first_name' => 'Guest',
                'email' => $email,
                'phone' => $phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        \App\Models\Ticket::create([
            'order_id' => $orderId,
            'exhibition_id' => $exhibition->id,
            'email' => $email,
            'phone' => $phone,
            'status' => 'pending',
            'snap_token' => $snapToken,
        ]);

        return response()->json(['token' => $snapToken]);
    }
}
