<?php

namespace App\Mail;

use App\Models\Academico\Matricula;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BienvenidaMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $matricula;
    public $nombre;
    public $ruta;

    /**
     * Create a new message instance.
     */
    public function __construct($id)
    {
        $this->matricula=Matricula::find($id);
        $this->nombre=$this->matricula->alumno->documento."_carnet.pdf";
        $rutapdf='carnet/'.$this->nombre;
        $this->ruta=Storage::url($rutapdf);
        Log::info('Mailable: ' . $id );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenido(a) '.strtoupper($this->matricula->alumno->name),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.bienvenida',
            with:[
                'matricula'=>$this->matricula,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array    {

        return [
            Attachment::fromPath($this->ruta),
        ];
    }
}
