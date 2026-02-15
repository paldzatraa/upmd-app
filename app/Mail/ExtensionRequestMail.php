<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExtensionRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $loan;

    public function __construct($loan) { $this->loan = $loan; }

    public function envelope(): Envelope {
        return new Envelope(subject: '⏳ Permintaan Perpanjangan: ' . $this->loan->item->name);
    }

    public function content(): Content {
        return new Content(view: 'emails.extension_request');
    }
}
