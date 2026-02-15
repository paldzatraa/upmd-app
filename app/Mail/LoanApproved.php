<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Peminjaman Disetujui: ' . $this->loan->item->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.loan_approved',
        );
    }
}