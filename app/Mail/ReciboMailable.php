<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReciboMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $recibo;
    public $detalles;

    /**
     * Create a new message instance.
     */
    public function __construct($recibo)
    {
        $this->recibo=$recibo;

        $this->detalles=DB::table('concepto_pago_recibo_pago')
                                    ->where('concepto_pago_recibo_pago.recibo_pago_id',$this->recibo->id)
                                    ->join('concepto_pagos', 'concepto_pago_recibo_pago.concepto_pago_id', '=', 'concepto_pagos.id')
                                    ->select('concepto_pagos.name', 'concepto_pago_recibo_pago.valor', 'concepto_pago_recibo_pago.tipo', 'concepto_pago_recibo_pago.producto', 'concepto_pago_recibo_pago.cantidad', 'concepto_pago_recibo_pago.unitario', 'concepto_pago_recibo_pago.subtotal', 'concepto_pago_recibo_pago.id_relacional')
                                    ->get();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Realizaste un pago con el Recibo N°: '.$this->recibo->numero_recibo,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.recibo',
            with:[
                'recibo'=>$this->recibo,
                'detalles'=>$this->detalles
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
