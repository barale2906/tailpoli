<?php

namespace App\Livewire\Inventario\Almacen;

use App\Models\Configuracion\Sede;
use App\Models\Inventario\Almacen;
use Livewire\Component;

class AlmacenesCreate extends Component
{
    public $name = '';
    public $sede_id = '';

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'sede_id');
    }

    // Cargar sede
    public function selSede($item)
    {
        $this->sede_id=$item;
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Almacen::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este almacen: '.$this->name);
        } else {
            //Crear registro
            Almacen::create([
                'name'=>strtolower($this->name),
                'sede_id'=>$this->sede_id,
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el almacen: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    //Sedes
    private function sedes()
    {
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.inventario.almacen.almacenes-create', [
            'sedes' => $this->sedes()
        ]);
    }
}
