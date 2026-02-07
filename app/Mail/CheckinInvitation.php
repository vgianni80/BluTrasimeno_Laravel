<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CheckinInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public string $propertyName;
    public string $propertyAddress;
    public string $checkinInstructions;
    public string $checkinUrl;

    public function __construct(public Booking $booking)
    {
        $this->propertyName = Setting::get('property_name', config('app.name'));
        $this->propertyAddress = Setting::get('property_address', '');
        $this->checkinInstructions = Setting::get('checkin_instructions', '');
        $this->checkinUrl = $booking->getCheckinUrl();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "✨ Completa il check-in - {$this->propertyName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.checkin-invitation',
        );
    }
}
