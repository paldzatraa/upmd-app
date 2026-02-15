<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanRejected extends Mailable
{
    public $loan;
    public $reason; // Variabel alasan

    public function __construct($loan, $reason) {
        $this->loan = $loan;
        $this->reason = $reason;
    }

    public function envelope(): Envelope {
        return new Envelope(subject: '❌ Peminjaman Ditolak');
    }

    public function content(): Content {
        return new Content(view: 'emails.loan_rejected');
    }
}