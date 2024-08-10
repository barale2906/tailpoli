<?php

namespace App\Livewire\Admin\Ayuda;

use App\Models\Menu;
use Livewire\Attributes\On;
use Livewire\Component;

class Ayudas extends Component
{
    public $crt;
    public $tipo;
    public $orid;
    public $is_detalle=false;
    public $videostate=true;
    public $pdfstate=false;
    public $is_pdf=false;

    #[On('cancelando')]
    public function cancelar(){
        $this->reset(
            'crt',
            'tipo',
            'orid',
            'is_detalle',
            'is_pdf'
        );
    }

    public function buscar($tipo,$item){
        $this->cancelar();
        $this->tipo=$tipo;

        switch ($tipo) {
            case 1:
                $this->crt=$item;
                $this->is_detalle=true;
                break;

            case 2:
                $this->orid=$item;
                $this->is_pdf=true;
                break;
        }

    }

    public function cambiaVista(){
        $this->videostate=!$this->videostate;
        $this->pdfstate=!$this->pdfstate;
        $this->reset('is_detalle','is_pdf');
    }

    private function menus(){
        return Menu::where('status',true)
                    ->get();
    }

    public function render()
    {
        return view('livewire.admin.ayuda.ayudas',[
            'menus'=>$this->menus(),
        ]);
    }
}
