<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Financiera\Cartera;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Convenio extends Component
{
    public $cartera;
    public $responsables=[];
    public $responsable_id;
    public $deudas;
    public $total;

    public function mount(){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
        $this->cartera=Cartera::Where('status', true)
                                ->get();

        $this->filtrar();
    }

    public function filtrar(){
        foreach ($this->cartera as $value) {
            $esta=DB::table('apoyo_recibo')->where('id_producto', $value->responsable_id)->count();

            //Cargar usuario a la tabla de apoyo
            if($esta===0){
                DB::table('apoyo_recibo')->insert([
                    'tipo'          =>'cartera',
                    'id_creador'    =>Auth::user()->id,
                    'valor'         =>0,
                    'id_producto'   =>$value->responsable_id,
                    'producto'      =>$value->responsable->name,
                    'almacen'       =>$value->responsable->documento
                ]);
            }
        }

        $this->ordenar();
    }

    public function ordenar(){
        $this->responsables=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('producto', 'ASC')
                                ->get();
    }

    public function updatedResponsableId()
    {
        $this->deudas=Cartera::where('responsable_id', $this->responsable_id)
                            ->where('status', true)
                            ->get();

        $this->total=Cartera::where('responsable_id', $this->responsable_id)
                            ->where('status', true)
                            ->sum('saldo');
    }

    public function render()
    {
        return view('livewire.cartera.cartera.convenio');
    }
}
