<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Configuracion\Sector;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ConfPagOtros;
use App\Models\Financiera\ConfPagOtrosDet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ConfiguracionOtrosEdit extends Component
{
    public $inicia;
    public $finaliza;
    public $descripcion;
    public $sector_id;

    public $elegidos=[];
    public $precio;
    public $cargados;

    public $actual;

    public function mount($elegido){
        $this->actual=ConfPagOtros::find($elegido);
        $this->asignar();

    }

    public function asignar(){

        $this->inicia=$this->actual->inicia;
        $this->finaliza=$this->actual->finaliza;
        $this->sector_id=$this->actual->sector_id;

        $this->cargados=ConfPagOtrosDet::where('conf_pag_otro_id', $this->actual->id)
                                        ->orderBy('name', 'ASC')
                                        ->get();

        $this->actuales();
    }

    public function actuales(){

        foreach ($this->cargados as $item) {
            $nuevo=[
                'id'=>$item->concepto_pago_id,
                'name'=>$item->name,
                'precio'=>$item->precio
            ];

            if(in_array($nuevo, $this->elegidos)){

            }else{
                array_push($this->elegidos, $nuevo);
            }
        }
    }

    //Cargar producto
    public function carProduc($item){

        $crt=0;
        foreach($this->elegidos as $value){
            if($value['id']===$item['id']){
                $crt=1;
                $this->dispatch('alerta', name:'Para modificar el producto eliminalo y lo vuelves a cargar.');
                $this->reset('precio');
            }
        }

        if($crt===0){
            $nuevo=[
                'id'=>$item['id'],
                'name'=>$item['name'],
                'precio'=>$this->precio
            ];

            if(in_array($nuevo, $this->elegidos)){

            }else{
                array_push($this->elegidos, $nuevo);
            }

            $this->reset('precio');
        }
    }

    //Eliminar producto
    public function elimProduc($id){

        foreach($this->elegidos as $value){
            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name'],
                    'precio'=>$value['precio'],
                ];

                $indice=array_search($nuevo,$this->elegidos,true);
                unset($this->elegidos[$indice]);
            }
        }
    }


    /**
     * Reglas de validación
     */
    protected $rules = [
        'inicia'=>'required',
        'finaliza'=>'required',
        'descripcion'=> 'required',
        'sector_id'=> 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(

            'inicia',
            'finaliza',
            'descripcion',
            'sector_id'
        );
    }

    //Actualizar
    public function edit(){

        // validate
        $this->validate();

        if($this->inicia>$this->finaliza){
            $this->dispatch('alerta', name:'La fecha de inicio debe ser menor a la fecha de finalización');
        }else if(count($this->elegidos)>0){

            $descri="--- ¡MODIFICADA! --- ".now()." ".Auth::user()->name." modifico la configuración de pago. --- "." --".$this->descripcion." -- ".$this->actual->descripcion;

            ConfPagOtros::whereId($this->actual->id)
                        ->update([
                            'inicia'        =>$this->inicia,
                            'finaliza'      =>$this->finaliza,
                            'descripcion'   =>$descri,
                            'sector_id'     =>$this->sector_id
                        ]);

            // Eliminar registros anteriores
            ConfPagOtrosDet::where('conf_pag_otro_id', $this->actual->id)->delete();

            // Cargar productos
            foreach ($this->elegidos as $value) {
                ConfPagOtrosDet::create([
                    'conf_pag_otro_id'  => $this->actual->id,
                    'concepto_pago_id'  => $value['id'],
                    'precio'            => $value['precio'],
                    'name'              => $value['name']
                ]);
            }

        }else{
            $this->dispatch('alerta', name:'Debe elegir conceptos para poder generar la configuración');
        }


        $this->dispatch('alerta', name:'Se ha editado correctamente la Configuración de Pago.');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    private function ciudades(){
        return Sector::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function conceptos(){
        return ConceptoPago::where('status', true)
                            ->where('tipo', 'otro')
                            ->orderBy('name')
                            ->get();

    }

    public function render()
    {
        return view('livewire.financiera.configuracion-pago.configuracion-otros-edit', [
            'ciudades'=>$this->ciudades(),
            'conceptos'=> $this->conceptos()
        ]);
    }
}
