<?php

namespace App\Livewire\Configuracion\Documento;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Palabras extends Component
{
    public $control=[];

    public function mount($control){
        $this->control=[0,$control];

    }

    private function palabras(){

        return DB::table('palabras_clave')
                    ->whereIn('control', $this->control)
                    ->where('status', true)
                    ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.documento.palabras',[
            'palabras'=>$this->palabras(),
        ]);
    }
}
