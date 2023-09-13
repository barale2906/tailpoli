<?php

namespace App\Livewire\Inventario\Almacen;

use App\Models\Configuracion\Sede;
use App\Models\Inventario\Almacen;
use Livewire\Component;

class AlmacenesEditar extends Component
{
    public $name = '';
    public $sede_id = '';
    public $nombreSede='';
    public $id = '';
    public $elegido;
    public $nombre;
    public $cambia=false;
    public $cambiaSed=true;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'sede_id'=>'required',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'id', 'sede_id');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
        $this->sede_id=$elegido['sede_id'];
        $this->nombreSede($elegido['sede_id']);
    }

    //Cargar nombre de sede
    public function nombreSede($id){
        $sede = Sede::where('id', $id)->first();
        $this->nombre=$sede->name;
    }

    // HAbilitar cambio
    public function changeSede()
    {
        $this->cambia=true;
        $this->sede_id='';

    }


    // Cargar sede
    public function selSede($item)
    {
        $this->sede_id=$item;
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Almacen::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este almacén: '.$this->name);
        } else {

            //Actualizar registros
            Almacen::whereId($this->id)->update([
                'sede_id'=>$this->sede_id,
                'name'=>strtolower($this->name),
            ]);
        }

        $this->dispatch('alerta', name:'Se ha modificado correctamente el almacén: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
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
        return view('livewire.inventario.almacen.almacenes-editar', [
            'sedes' => $this->sedes()
        ]);
    }
}
