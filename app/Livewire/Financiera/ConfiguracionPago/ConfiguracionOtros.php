<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Configuracion\Sector;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ConfPagOtros;
use App\Models\Financiera\ConfPagOtrosDet;
use Livewire\Component;

class ConfiguracionOtros extends Component
{
    public $inicia;
    public $finaliza;
    public $descripcion;
    public $sector_id;
    public $elegidos=[];
    public $precio;

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

    //Cargar producto
    public function car($item){

        $crt=0;
        foreach($this->elegidos as $value){
            if($value['id']===$item['id']){
                $crt=1;
                $this->dispatch('alerta', name:'el concepto '.$item['name'].' ya esta cargado.');
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
        'inicia'                => 'required',
        'finaliza'              => 'required',
        'descripcion'           => 'required',
        'sector_id'             => 'required|integer'
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
                        'sector_id',
                    );
    }

    // Crear
    public function new(){
        // validate
        $this->validate();
        if($this->inicia>$this->finaliza){
            $this->dispatch('alerta', name:'La fecha de inicio debe ser menor a la fecha de finalización');
        }else if(count($this->elegidos)>0){

            $status=true;
            if(now()<$this->inicia){
                $status=!$status;
            }

            $config=ConfPagOtros::create([
                'inicia'        =>$this->inicia,
                'finaliza'      =>$this->finaliza,
                'descripcion'   =>$this->descripcion,
                'sector_id'     =>$this->sector_id,
                'status'        =>$status
            ]);

            // Cargar productos
            foreach ($this->elegidos as $value) {
                ConfPagOtrosDet::create([
                    'conf_pag_otro_id'  => $config->id,
                    'precio'            => $value
                ]);
            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente la configuración de pago');
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('cancelando');

        }else{
            $this->dispatch('alerta', name:'Debe elegir conceptos para poder generar la configuración');
        }

    }

    public function render()
    {
        return view('livewire.financiera.configuracion-pago.configuracion-otros', [
            'ciudades'=>$this->ciudades(),
            'conceptos'=>$this->conceptos(),
        ]);
    }
}
