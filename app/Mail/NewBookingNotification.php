<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public int $totalNew = 1
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🏠 Nuova prenotazione da completare - {$this->booking->check_in->format('d/m/Y')}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-booking',
        );
    }
}
