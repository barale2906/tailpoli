<?php

namespace App\Traits;

use App\Mail\BienvenidaMailable;
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
        }
    }

    public function reciboCaja($id){

        $recibo=ReciboPago::find($id);
        $saldo=Cartera::where('responsable_id', $recibo->paga_id)
                        ->where('status', true)
                        ->sum('saldo');

        $destinatario=$recibo->paga->email;

        Mail::to($destinatario)->send(new ReciboMailable($recibo, $saldo));

    }

    public function carnetpdf($id){

        $mat=Matricula::where('id',$id)
                        ->first();

        $destinatario=$mat->alumno->email;
        var_dump($destinatario);
        Log::info('Destinatario: '.$destinatario );
        Mail::to($destinatario)->send(new BienvenidaMailable($id));
    }
}
