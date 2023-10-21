<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\ConceptoPago;
use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class InventariosCreate extends Component
{
    public $sede_id;
    public $sede;
    public $almacen_id;

    public $medio;
    public $cantidad;
    public $precio;

    public $buscar=null;
    public $buscaestudi='';
    public $alumno_id=0;
    public $alumnoName;




    public $tipo;
    public $movimientos;
    public $Total=0;
    public $id_ultimo;
    public $saldo;
    public $conceptopago;

    public function mount(){
        $this->borrar();
    }

    #[On('borrarMov')]
    public function borrar(){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
    }

    public function updatedTipo(){
        $this->reset('sede_id', 'almacen_id');
        $this->borrar();
    }

    public function updatedSedeId(){
        $this->reset('sede', 'almacen_id');
        $this->sede=Sede::find($this->sede_id);
    }

    public function updatedAlmacenId(){
        $this->reset('almacen');
    }

    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscar');
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->limpiar();
    }

    private function sedes(){
        return Sede::query()
                    ->with(['users'])
                    ->when(Auth::user()->id, function($qu){
                        return $qu->where('status', true)
                                ->whereHas('users', function($q){
                                    $q->where('user_id', Auth::user()->id);
                                });
                    })
                    ->orderBy('name')
                    ->get();
    }

    private function estudiantes(){
        return User::where('status', true)
                        ->where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('documento', 'like', "%".$this->buscaestudi."%")
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                        );
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-create',[
            'sedes'         =>$this->sedes(),
            'estudiantes'   =>$this->estudiantes()
        ]);
    }
}
