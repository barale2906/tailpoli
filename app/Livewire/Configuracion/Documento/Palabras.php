<?php

namespace App\Livewire\Configuracion\Documento;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Palabras extends Component
{
    private function palabras(){

        return DB::table('palabras_clave')
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
