<?php

namespace App\Livewire\Layouts;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Configuracion\Estado;
use App\Models\Financiera\Transaccion;
use App\Models\Inventario\Inventario;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    protected $listeners = ['refresh' => '$refresh'];

    public $sedes=[];


    public function mount(){
        foreach (Auth::user()->sedes as $value) {
            if(in_array($value->id, $this->sedes )){

            }else{
                array_push($this->sedes, $value->id);
            }
        }
    }

    private function menus(){
        return Menu::where('status',true)
                    ->get();
    }

    private function pendInventarios(){

        return Inventario::where('tipo', 2)
                            ->where('entregado', false)
                            ->count('entregado');
    }

    private function transacciones(){
        return Transaccion::whereIn('status', [1,2,3])
                            ->count();
    }

    private function matriculas(){

        $fecha=Carbon::today();

        return Matricula::where('creador_id', Auth::user()->id)
                            ->where('created_at', '>=',$fecha)
                            ->count();
    }

    private function proximos(){
        return Control::where('status', true)
                        ->whereIn('sede_id', $this->sedes)
                        ->where('estado_cartera', 4)
                        ->count();
    }

    private function vencidos(){
        return Control::where('status', true)
                        ->whereIn('sede_id', $this->sedes)
                        ->where('estado_cartera', 5)
                        ->count();
    }

    private function desertados(){

        $estado=Estado::where('status', true)
                        ->where('name', 'desertado')
                        ->select('id')
                        ->first();

        return Control::where('status', true)
                        ->whereIn('sede_id', $this->sedes)
                        ->where('status_est', $estado->id)
                        ->count();
    }

    public function render()
    {
        return view('livewire.layouts.navbar', [
            'menus'=>$this->menus(),
            'pendInventarios'=>$this->pendInventarios(),
            'transacciones'=>$this->transacciones(),
            'matriculas'=>$this->matriculas(),
            'proximos'=>$this->proximos(),
            'vencidos'=>$this->vencidos(),
            'desertados'=>$this->desertados()
        ]);
    }
}
