<?php

namespace App\Livewire\Admin\Ayuda;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Detalle extends Component
{
    public $crt;
    public $is_video=false;
    public $seleccionado;
    public $ruta;
    public $modulos;


    public function mount($crt){
        $this->reset('crt','is_video','seleccionado','modulos');

        $this->inicia($crt);

    }

    public function inicia($item){

        $this->crt=$item;
        $this->modul();
    }

    public function modul(){
        $this->modulos = DB::table('ayudas')
                    ->where('modulo', $this->crt)
                    ->where('status', true)
                    ->orderBy('titulo')
                    ->get();
    }

    public function ver($id){
        $this->volver();

        $this->seleccionado=DB::table('ayudas')
                            ->where('id', $id)
                            ->first();

        // cargar visita
        DB::table('ayudavisitas')
            ->insert([
                'visitante'         =>Auth::user()->id,
                'nombre_visitante'  =>Auth::user()->name,
                'tema'              =>$this->seleccionado->titulo,
                'created_at'        =>now(),
                'updated_at'        =>now(),
            ]);

        $this->ruta=Storage::url($this->seleccionado->ruta);

        $this->is_video=true;
    }

    public function volver(){
        $this->reset('ruta','is_video', 'seleccionado');
    }

    public function render()
    {
        return view('livewire.admin.ayuda.detalle');
    }
}
