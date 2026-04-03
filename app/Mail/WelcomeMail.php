<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Welcome to Fridah's Spice 🌶️",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome', // this must match your blade file
        );
    }

    public function attachments(): array
    {
        return [];
    }
}