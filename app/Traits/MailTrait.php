<?php

namespace App\Traits;

use App\Mail\ReciboMailable;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\Mail;

trait MailTrait
{
    public function claseEmail($clase,$info){
        switch ($clase) {
            case 1:
                $this->reciboCaja($info);
                break;
        }
    }

    public function reciboCaja($id){

        $recibo=ReciboPago::find($id);

        $destinatario=$recibo->paga->email;

        Mail::to($destinatario)->send(new ReciboMailable($recibo));

    }
}
