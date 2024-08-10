<?php

namespace App\Livewire\Admin\Ayuda;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Detalle extends Component
{
    public $crt;
    public $tipo;
    public $is_video=false;
    public $is_pdfs=false;
    public $seleccionado;
    public $ruta;
    public $modulos;
    public $consulta;


    public function mount($tipo,$crt){
        $this->reset('crt','is_video','seleccionado','modulos','tipo');

        $this->inicia($crt,$tipo);

    }

    public function inicia($item,$tipo){

        $this->crt=$item;
        $this->tipo=$tipo;
        switch ($tipo) {
            case 1:
                $this->modul();
                break;

            case 2:
                $this->modulpdf();
                break;
        }

    }

    public function modul(){
        $this->modulos = DB::table('ayudas')
                            ->where('modulo', $this->crt)
                            ->where('tipo', $this->tipo)
                            ->where('status', true)
                            ->orderBy('titulo')
                            ->get();
    }

    public function modulpdf(){
        $this->modulos = DB::table('ayudas')
                            ->where('modulo_id', $this->crt)
                            ->where('tipo', $this->tipo)
                            ->where('status', true)
                            ->orderBy('titulo')
                            ->get();
    }

    public function consultado(){
        $this->consulta=$this->modulos[0]->modulo;
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

        switch ($this->tipo) {
            case 1:
                $this->is_video=true;
                break;

            case 2:
                $this->is_pdfs=true;
                break;
        }
    }

    public function volver(){
        $this->reset('ruta','is_video', 'seleccionado','is_pdfs');
    }

    public function render()
    {
        return view('livewire.admin.ayuda.detalle');
    }
}
