<?php

namespace App\Livewire\Cliente\Crm;

use App\Imports\CrmImport;
use App\Models\Configuracion\Sector;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CrmImportar extends Component
{
    use WithFileUploads;

    public $archivo;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'archivo'    => 'required|mimes:xls,xlsx'
    ];

    public function importar(){

        // validate
        $this->validate();

        Excel::import(new CrmImport, $this->archivo);

        $this->reset('archivo');
        $this->dispatch('alerta', name:'Se importo correctamente el archivo ');

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');


    }


    private function ciudades(){
        return Sector::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }
    public function render()
    {
        return view('livewire.cliente.crm.crm-importar',[
            'ciudades'=>$this->ciudades()
        ]);
    }
}
