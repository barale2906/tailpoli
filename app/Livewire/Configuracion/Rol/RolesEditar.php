<?php

namespace App\Livewire\Configuracion\Rol;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesEditar extends Component
{
    public $name = '';
    public $id = '';
    public $permis = [];
    public $rolEleg;
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'id'    => 'required',
        'permis'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'id', 'permis');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
        $this->permi();
    }

    //obtener permisos
    public function permi(){
        $this->rolEleg= Role::whereId($this->id)->first();
        //dd($rol->permissions);
        //$this->permis=$rol->permissions;
        foreach ($this->rolEleg->permissions as $value) {
            array_push($this->permis,$value->id);
        }
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Role::whereId($this->id)->update([
            'name'=>strtolower($this->name)
        ]);

        //Actualizar permisos
        //$this->rolEleg->permissions()->sync($this->permis);
        $this->rolEleg->syncPermissions($this->permis);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el Rol: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
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

    private function permissions(){
        return Permission::orderBy('id')
                            ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.rol.roles-editar', [
            'permisosac'=>$this->permisosac(),
            'permisosca'=>$this->permisosca(),
            'permisosfi'=>$this->permisosfi(),
            'permisosin'=>$this->permisosin(),
            'permisosre'=>$this->permisosre(),
            'permisosad'=>$this->permisosad(),
            'permisosar'=>$this->permisosar(),
            'permisosco'=>$this->permisosco(),
            'permissions'=>$this->permissions(),
        ]);
    }
}
