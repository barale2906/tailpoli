<?php

namespace App\Livewire\Configuracion\Rol;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesCreate extends Component
{
    public $name = '';
    public $permis = [];

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'permis'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'permis');

    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Role::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este rol: '.$this->name);
        } else {
            //Crear registro
            $rol = Role::create([
                'name'=>strtolower($this->name),
            ]);

            //Asignar permisos
            $rol->givePermissionTo($this->permis);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el rol: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    private function permisosac(){
        return Permission::where('name', 'like', 'ac%')
                            ->orderBy('id')
                            ->get();
    }

    private function permisosca(){
        return Permission::where('name', 'like', 'ca%')
                            ->orderBy('id')
                            ->get();
    }

    private function permisosfi(){
        return Permission::where('name', 'like', 'fi%')
                            ->orderBy('id')
                            ->get();
    }

    private function permisosin(){
        return Permission::where('name', 'like', 'in%')
                            ->orderBy('id')
                            ->get();
    }

    private function permisosre(){
        return Permission::where('name', 'like', 're%')
                            ->orderBy('id')
                            ->get();
    }

    private function permisosad(){
        return Permission::where('name', 'like', 'ad%')
                            ->orderBy('id')
                            ->get();
    }

    private function permisosar(){
        return Permission::where('name', 'like', 'ar%')
                            ->orderBy('id')
                            ->get();
    }

    private function permisosco(){
        return Permission::where('name', 'like', 'co%')
                            ->orderBy('id')
                            ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.rol.roles-create', [
            'permisosac'=>$this->permisosac(),
            'permisosca'=>$this->permisosca(),
            'permisosfi'=>$this->permisosfi(),
            'permisosin'=>$this->permisosin(),
            'permisosre'=>$this->permisosre(),
            'permisosad'=>$this->permisosad(),
            'permisosar'=>$this->permisosar(),
            'permisosco'=>$this->permisosco(),
        ]);
    }
}
