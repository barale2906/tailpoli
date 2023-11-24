<?php

namespace App\Traits;

use App\Models\Financiera\CierreCaja;
use Illuminate\Support\Facades\Auth;

trait ComunesTrait
{


    public $is_dia=true;

    public function cierre(){

        $this->reset('is_dia');
        $fecha=now();
        $fecha=date('Y-m-d');

        $cerrado=CierreCaja::where('dia', false)
                            ->where('fecha', $fecha)
                            ->where('cajero_id', Auth::user()->id)
                            ->count('id');

        if($cerrado>0){
            $this->is_dia=!$this->is_dia;
        }


    }
}
