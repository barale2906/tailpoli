<?php

namespace App\Livewire\Configuracion\Rol;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permisos extends Component
{
    public $buscar=null;
    public $buscaestudi='';
    public $user;
    public $permis=[];

    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscar');
    }

    public function selAlumno($item){

        $this->user=User::find($item['id']);
        $this->limpiar();
        $this->permisGeneral();
    }

    public function permisGeneral(){
        $this->reset('permis');
        $datos=$this->user->getAllPermissions();
        foreach ($datos as $value) {
            array_push($this->permis,$value->id);
        }
    }

    public function actualizar(){

        $this->user->syncPermissions($this->permis);

        $this->dispatch('alerta', name:'Se actualizaron los permisos para: '.$this->user->name);
        $this->reset('user', 'permis');
        $this->dispatch('cancelando');
    }

    private function usuarios(){
        return User::where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('documento', 'like', "%".$this->buscaestudi."%")
                        ->orderBy('name')
                        ->get();
    }

    private function listaPermisos(){
        return Permission::all();
    }

    private function encabezados(){
        return Permission::groupBy('modulo')
                            ->select('modulo')
                            ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.rol.permisos',[
            'usuarios'=>$this->usuarios(),
            'listaPermisos'=>$this->listaPermisos(),
            'encabezados'   => $this->encabezados()
        ]);
    }
}
