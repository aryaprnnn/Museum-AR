<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $exhibition;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->exhibition = $ticket->exhibition;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Pameran - ARtifact Museum',
        );
    }

    public function content(): Content
    {
        // We reuse the existing booking confirmation view but pass different data if needed,
        // or create a new one. For now, let's create a specific view if possible, 
        // or just use booking-confirmation with conditional logic.
        // Let's assume we'll use a new view 'emails.ticket-confirmation' for clarity.
        return new Content(
            view: 'emails.ticket-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
