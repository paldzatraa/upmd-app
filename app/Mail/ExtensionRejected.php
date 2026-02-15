<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExtensionRejected extends Mailable
{
    public $loan;
    public $reason;

    public function __construct($loan, $reason) {
        $this->loan = $loan;
        $this->reason = $reason;
    }

    public function envelope(): Envelope {
        return new Envelope(subject: '❌ Perpanjangan Ditolak');
    }

    public function content(): Content {
        return new Content(view: 'emails.extension_rejected');
    }
}
