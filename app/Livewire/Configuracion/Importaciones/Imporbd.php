<?php

namespace App\Livewire\Configuracion\Importaciones;

use App\Imports\AlamcenesImnport;
use App\Imports\CursosImport;
use App\Imports\EstudianteImport;
use App\Imports\GruposImport;
use App\Imports\MatriculaImport;
use App\Imports\ModulosImport;
use App\Imports\ProductosImport;
use App\Imports\RegimenSaludImport;
use App\Imports\SectorsImport;
use App\Imports\SedesImport;
use App\Imports\StatesImport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Imporbd extends Component
{
    use WithFileUploads;

    public $archivo;
    public $tabla="a";
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

            case 0:
                Excel::import(new EstudianteImport, $this->archivo);
                break;

            case 1:
                Excel::import(new UsersImport, $this->archivo);
                break;

            case 8:
                Excel::import(new RegimenSaludImport, $this->archivo);
                //return Excel::toCollection(new RegimenSaludImport, $this->archivo);
                break;

            case 11:
                Excel::import(new ProductosImport, $this->archivo);
                break;

            case 12:
                Excel::import(new CursosImport, $this->archivo);
                break;

            case 15:
                Excel::import(new StatesImport, $this->archivo);
                break;

            case 16:
                Excel::import(new SectorsImport, $this->archivo);
                break;

            case 17:
                Excel::import(new SedesImport, $this->archivo);
                break;

            case 19:
                Excel::import(new AlamcenesImnport, $this->archivo);
                break;

            case 20:
                Excel::import(new ModulosImport, $this->archivo);
                break;

            case 23:
                Excel::import(new GruposImport, $this->archivo);
                break;

            case 27:
                Excel::import(new MatriculaImport, $this->archivo);
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
