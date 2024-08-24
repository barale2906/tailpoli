<?php

namespace App\Traits;

use App\Mail\BienvenidaMailable;
use App\Mail\RecartMailable;
use App\Mail\ReciboMailable;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait MailTrait
{
    public function claseEmail($clase,$info){
        switch ($clase) {
            case 1:
                $this->reciboCaja($info);
                break;

            case 2:
                $this->carnetpdf($info);
                break;

            case 3:
                $this->recordatorio($info);
                break;

            case 4:
                $this->cobranza($info);
                break;

            case 5:
                $this->cobranzanegociacion($info);
                break;

            case 6:
                $this->cobranzareporte($info);
                break;

            case 7:
                $this->cobranzareportenegoci($info);
                break;
        }
    }

    public function reciboCaja($id){

        $recibo=ReciboPago::find($id);
        $saldo=Cartera::where('responsable_id', $recibo->paga_id)
                        ->where('status', '<',5)
                        ->sum('saldo');

        $destinatario=$recibo->paga->email;

        Mail::to($destinatario)->send(new ReciboMailable($recibo, $saldo));

    }

    public function carnetpdf($id){

        $mat=Matricula::where('id',$id)
                        ->first();

        $destinatario=$mat->alumno->email;
        Mail::to($destinatario)->send(new BienvenidaMailable($id));
    }

    public function recordatorio($id){

        $cartera=Cartera::find($id);

        $destinatario=$cartera->responsable->email;
        Mail::to($destinatario)->send(new RecartMailable($id));
        Log::info('AvisoCartera: envio correo a: ' . $destinatario);
    }

    public function cobranza($id){
        //Envío de carta inicio cobranza

        $cartera=Cartera::find($id);

        $destinatario=$cartera->responsable->email;
        Mail::to($destinatario)->send(new RecartMailable($id));
        Log::info('AvisoCartera: envio correo a: ' . $destinatario);
    }

    public function cobranzanegociacion($id){
        //Envío de carta negociación cobranza

        $cartera=Cartera::find($id);

        $destinatario=$cartera->responsable->email;
        Mail::to($destinatario)->send(new RecartMailable($id));
        Log::info('AvisoCartera: envio correo a: ' . $destinatario);
    }

    public function cobranzareporte($id){
        //Envío de carta de notificación de reporte a centrales

        $cartera=Cartera::find($id);

        $destinatario=$cartera->responsable->email;
        Mail::to($destinatario)->send(new RecartMailable($id));
        Log::info('AvisoCartera: envio correo a: ' . $destinatario);
    }

    public function cobranzareportenegoci($id){
        //Envío de carta negocia retiro reporte
        $cartera=Cartera::find($id);

        $destinatario=$cartera->responsable->email;
        Mail::to($destinatario)->send(new RecartMailable($id));
        Log::info('AvisoCartera: envio correo a: ' . $destinatario);
    }
}
