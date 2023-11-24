<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Desbloquear extends Component
{
    public $cierre;
    public $fecha;

    public function desbloq(){
        $cierre=CierreCaja::whereId($this->cierre)
                            ->first();

        $obs=now()." ".Auth::user()->name." DESBLOQUEO la caja. ----- ".$cierre->observaciones;

        $cierre->update([
            'dia'           =>true,
            'observaciones' =>$obs,
        ]);



        $this->dispatch('alerta', name:'Ha sido desbloqueado correctamente el cajero: '.$cierre->cajero->name);
        $this->dispatch('cancelando');
    }

    private function cierres(){
        $this->fecha=now();
        $this->fecha=date('Y-m-d');
        return CierreCaja::where('fecha', $this->fecha)
                            ->orderBy('fecha_cierre', 'DESC')
                            ->get();
    }


    public function render()
    {
        return view('livewire.financiera.cierre-caja.desbloquear', [
            'cierres'=>$this->cierres(),
        ]);
    }
}
