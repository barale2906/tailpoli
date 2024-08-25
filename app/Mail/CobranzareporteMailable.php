<?php

namespace App\Mail;

use App\Models\Financiera\Cobranza;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CobranzareporteMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $cobro;
    public $ruta;

    /**
     * Create a new message instance.
     */
    public function __construct($id)
    {
        $this->cobro=Cobranza::find($id);
        //Buscar el documento descargado
        $nombre=$this->cobro->alumno->documento."-".$id."_cobranreporte.pdf";
        $rutapdf='cobranreporte/'.$nombre;
        $this->ruta=Storage::url($rutapdf);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡REPORTE CENTRALES '.strtoupper($this->cobro->alumno->name).'!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.cobranzareporte',
            with:[
                'cobro'=>$this->cobro,
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
        return [
            Attachment::fromPath($this->ruta),
        ];
    }
}
