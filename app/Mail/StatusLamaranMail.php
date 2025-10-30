<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusLamaranMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Status Lamaran Mail',
        );
    }

    //  use Queueable, SerializesModels;

    public $nama;
    public $status;
    public $pekerjaan;

    public function __construct($nama, $status, $pekerjaan)
    {
        $this->nama = $nama;
        $this->status = $status;
        $this->pekerjaan = $pekerjaan;
    }

    public function build()
    {
        return $this->subject('Update Status Lamaran Pekerjaan')
                    ->view('emails.status_lamarans');
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
