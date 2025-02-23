<?php

namespace App\Livewire\Financiera\Descuento;

use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\Descuento;
use App\Traits\CrtStatusTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function Laravel\Prompts\table;

class Descugestiona extends Component
{
    use CrtStatusTrait;

    public $name;
    public $valor;
    public $tipo;
    public $aplica;
    public $actual;
    public $conceptos;
    public $tiponom;
    public $asignados;


    public function mount($elegido=null){
        $this->resetFields();
        if($elegido){
            $this->actual=Descuento::find($elegido);
            $this->valores();
        }
    }

    public function valores(){
        $this->name = $this->actual->name;
        $this->valor = $this->actual->valor;
        $this->tipo = $this->actual->tipo;
        $this->aplica = $this->actual->aplica;

        $this->concep();
    }

    public function concep(){

        $this->reset('tiponom');

        switch (intval($this->aplica)) {
            case 0:
                $this->tiponom="cartera";
                break;

            case 1:
                $this->tiponom="inventario";
                break;

            case 2:
                $this->tiponom="otro";
                break;
        }
        $this->conceptos=ConceptoPago::where('tipo', $this->tiponom)
                                        ->where('status', 1)
                                        ->orderBy('name', 'ASC')
                                        ->get();

        $this->concepasignados();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'         => 'required',
        'valor'        => 'required|numeric|min:0',
        'tipo'         => 'required',
        'aplica'       => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'name',
                        'valor',
                        'tipo',
                        'aplica',
                        'actual'
                    );
    }

    public function regresar(){
        $this->resetFields();
        $this->dispatch('volviendo');
    }

    public function new(){
        // validate
        $this->validate();

        //Inactiva descuento anterior
        Descuento::where('aplica',$this->aplica)
                    ->update([
                        'status' => 0
                    ]);

        $this->actual=Descuento::create([
                                    'name' => strtolower($this->name),
                                    'valor' => $this->valor,
                                    'tipo' => $this->tipo,
                                    'aplica' => $this->aplica,
                                    'status' => 1
                                ]);



        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el descuento: '.$this->name);
        //$this->resetFields();

        //refresh
        //$this->dispatch('volviendo');
        $this->concep();
    }

    public function editar(){
        // validate
        $this->validate();

        Descuento::where('id', $this->actual->id)
                    ->update([
                        'name' => strtolower($this->name),
                        'valor' => $this->valor,
                        'tipo' => $this->tipo,
                        'aplica' => $this->aplica,
                    ]);

        if(intval($this->aplica) !== $this->actual->aplica){
            DB::table('descuento_producto')
                ->where('descuento_id', $this->actual->id)
                ->delete();

        }

        // Notificación
        $this->dispatch('alerta', name:'Se ha modificado correctamente el descuento: '.$this->name);
        //$this->resetFields();

        //refresh
        //$this->dispatch('volviendo');
        $this->concep();

    }

    public function cargar($id){
        DB::table('descuento_producto')
            ->insert([
                'descuento_id'      => $this->actual->id,
                'concepto_pago_id'  => $id,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);

        $this->concepasignados();
    }

    public function eliminar($id){
        DB::table('descuento_producto')
            ->where('id', $id)
            ->delete();

        $this->concepasignados();
    }

    public function concepasignados(){

        $this->asignados=DB::table('concepto_pagos')
                            ->join('descuento_producto', 'concepto_pagos.id', '=', 'descuento_producto.concepto_pago_id')
                            ->where('descuento_producto.descuento_id',$this->actual->id)
                            ->select('concepto_pagos.*','descuento_producto.id as elegido')
                            ->orderBy('concepto_pagos.name', 'ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.financiera.descuento.descugestiona');
    }
}
