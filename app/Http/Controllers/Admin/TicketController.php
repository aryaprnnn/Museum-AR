<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Exhibition;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('exhibition')->orderByDesc('created_at')->paginate(20);
        return view('admin.tickets.index', compact('tickets'));
    }
}
