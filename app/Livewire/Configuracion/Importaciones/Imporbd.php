<?php

namespace App\Livewire\Configuracion\Importaciones;

use App\Imports\RegimenSaludImport;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Imporbd extends Component
{
    use WithFileUploads;

    public $archivo;
    public $tabla;
    public $alerta=false;

    public function alarma(){
        $this->alerta=!$this->alerta;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'archivo'    => 'required|mimes:xls,xlsx'
    ];

    public function importar(){

        // validate
        $this->validate();

        $id=intval($this->tabla);

        switch ($id) {
            case 8:
                Excel::import(new RegimenSaludImport, $this->archivo);
                //return Excel::toCollection(new RegimenSaludImport, $this->archivo);
                break;
        }

        $this->reset('archivo', 'tabla', 'alerta');
        $this->dispatch('alerta', name:'Se importo correctamente el archivo ');

        //refresh
        $this->dispatch('refresh');


    }

    private function tablas(){
        return DB::table('migrations')->get();

    }
    public function render()
    {
        return view('livewire.configuracion.importaciones.imporbd', [
            'tablas'=>$this->tablas()
        ]);
    }
}
