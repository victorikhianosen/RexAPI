<?php

namespace App\Mail\Business;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BusinessRegisterMail extends Mailable
{
    use Queueable, SerializesModels;


    public $firstName, $otp;
    public function __construct($firstName, $otp)
    {
        $this->firstName = $firstName;
        $this->otp = $otp;

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Business Register Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'business.emails.register',
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
