<?php

namespace App\Livewire\Reportes;

use Livewire\Component;

class Academicos extends Component
{
    public $is_reporte=false;
    public $clase;

    public function cancelando(){
        $this->reset(
            'is_reporte',
            'clase'
        );
    }

    public function show($id){
        $this->cancelando();
        $this->clase=$id;
        $this->is_reporte=true;
    }

    public function render()
    {
        return view('livewire.reportes.academicos');
    }
}
