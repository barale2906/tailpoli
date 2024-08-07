<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\Transaccion;
use App\Traits\ComunesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class InventariosCreate extends Component
{
    use ComunesTrait;

    public $sede_id;
    public $sede;
    public $almacen_id;
    public $tipo;
    public $crtAlma=true;
    public $todo=true;
    public $ruta;
    public $transaccion;

    public function mount($ruta=null, $transaccion=null){
        $this->borrar();
        $this->ruta=$ruta;
        if($transaccion){
            $this->transaccion=Transaccion::find($transaccion);
            $this->tipo=0;
        }
    }

    #[On('borrarMov')]
    public function borrar(){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
    }

    #[On('mostodo')]
    public function estodo(){
        $this->todo=!$this->todo;
    }

    public function updatedTipo(){
        $tipoes=intval($this->tipo);
        if($tipoes===0){
            $this->cierre();
        }
        $this->reset('sede_id', 'almacen_id', 'crtAlma');
        $this->borrar();
    }

    public function updatedSedeId(){
        $this->reset('sede', 'almacen_id', 'crtAlma');
        $this->sede=Sede::find($this->sede_id);
    }

    public function updatedAlmacenId(){
        //$this->reset('almacen_id');
        $this->crtAlma=!$this->crtAlma;
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

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-create',[
            'sedes'         =>$this->sedes()
        ]);
    }
}
