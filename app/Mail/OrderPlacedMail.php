<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Email subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmed - Fridah\'s Spice'
        );
    }

    /**
     * Email content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-placed',
            with: [
                'transaction' => $this->transaction,
                'user' => $this->transaction->user,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}