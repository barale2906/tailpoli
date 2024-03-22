<?php

namespace App\Livewire\Reportes;

use Livewire\Component;

class Financieros extends Component
{
    public $is_cartera=false;
    public $is_pagos=false;
    public $is_crm=false;

    public function cancelando(){
        $this->reset(
            'is_cartera',
            'is_pagos',
            'is_crm'
        );
    }

    public function show($id){

        $this->cancelando();
        switch ($id) {
            case 1:
                $this->is_cartera=true;
                break;

            case 2:
                $this->is_pagos=true;
                break;

            case 3:
                $this->is_crm=true;
                break;

        }

    }

    public function render()
    {
        return view('livewire.reportes.financieros');
    }
}
