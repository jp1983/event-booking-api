<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, string $pdfPaths) {
        $this->booking = $booking;
        $this->pdfPath = $pdfPath;
    }

    /*
     * Send Email 
     */
    public function build() {
        return $this->subject('Booking Confirmation')
                    ->view('emails.booking')
                    ->with(['booking' => $this->booking])
                    ->attach($this->pdfPath);

    }   

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
