<?php

namespace App\Livewire\Admin\Ayuda;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Detalle extends Component
{
    public $crt;
    public $is_video=false;
    public $ruta;

    public function mount($crt){
        $this->crt=$crt;
    }

    private function modulos(){
        return DB::table('ayudas')
                    ->where('modulo', $this->crt)
                    ->where('status', true)
                    ->orderBy('titulo')
                    ->get();
    }

    public function ver($id){
        $this->reset('ruta');

        $sel=DB::table('ayudas')
                    ->where('id', $id)
                    ->first();

        $this->ruta=Storage::url($sel->ruta);

        $this->is_video=true;
    }

    public function render()
    {
        return view('livewire.admin.ayuda.detalle',[
            'modulos'=>$this->modulos(),
        ]);
    }
}
