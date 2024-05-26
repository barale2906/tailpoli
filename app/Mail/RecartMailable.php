<?php

namespace App\Mail;

use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RecartMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    Public $cartera;
    public $hoy;
    public $destinatario;

    /**
     * Create a new message instance.
     */
    public function __construct($id)
    {
        $this->hoy=Carbon::today();
        $this->cartera=Cartera::find($id);
        $this->destinatario='¡Esta información es importante para ti '.strtoupper($this->cartera->responsable->name).'!';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->destinatario,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.recordatorioCartera',
            with:[
                'cartera'=>$this->cartera,
                'hoy'=>$this->hoy,
            ],
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
