<?php

namespace App\Livewire\Impresiones;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpContrato extends Component
{
    #[Url(as: 'c')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;

    public $contrato;
    public $matricula;

    public function mount(){

        if($this->ori){
            $this->contrato=Documento::whereId($this->id)->first();

            $this->matricula=Matricula::where('status', true)
                                        ->orderBy('id', 'DESC')
                                        ->first();
        }else{
            $this->contrato=Documento::where('status', 3)
                                        ->where('tipo', 'contrato')
                                        ->first();

            $this->matricula=Matricula::whereId($this->id)->first();
        }

    }

    public function prueba(){
        $prueba=DB::table('detalle_documento')
                    ->where('documento_id', $this->id)
                    ->orderBy('orden', 'ASC')
                    ->first();

        $phrase  = $prueba->contenido;
        $palabra=Auth::user()->name;
        $healthy = array("nombreEstu");
        $yummy   = array($palabra);

        $newphrase = str_replace($healthy, $yummy, $phrase);

        //dd($newphrase);


    }


    public function render()
    {
        return view('livewire.impresiones.imp-contrato');
    }
}
