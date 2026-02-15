<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLoanRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $loan; // Data peminjaman yang akan dikirim

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Pengajuan Peminjaman Baru: ' . $this->loan->item->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_loan', // Kita akan buat view ini di bawah
        );
    }
}