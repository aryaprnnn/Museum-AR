<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class ExhibitionTicketController extends Controller
{
    public function index()
    {
        $user = session('auth_user');
        if (!$user) {
            return redirect()->route('login');
        }

        $tickets = Ticket::where('user_id', $user['id'])
            ->with(['exhibition'])
            ->orderByDesc('created_at')
            ->get();

        return view('front.pages.user.tickets', compact('tickets'));
    }

    public function show($code)
    {
        $user = session('auth_user');
        if (!$user) {
            return redirect()->route('login');
        }

        $ticket = Ticket::where('order_id', $code)
            ->where('user_id', $user['id'])
            ->with(['exhibition'])
            ->firstOrFail();

        return view('front.pages.user.ticket-detail', compact('ticket'));
    }
}
