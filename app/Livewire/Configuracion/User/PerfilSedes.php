<?php

namespace App\Livewire\Configuracion\User;

use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PerfilSedes extends Component
{
    public $actual;

    public $sedeperte;
    public $noperte;

    public function mount($elegido){
        $this->actual=User::find($elegido);

        $this->sedePendiente();
    }

    //sedes a las que no pertenece
    public function sedePendiente(){

        $this->noperte = Sede::where('status', true)->orderBy('name', 'ASC')->get();
    }

    //Elegir sedes a las que pertenece
    public function sel($id){

        $ya=DB::table('sede_user')->where('user_id',$this->actual->id)->where('sede_id', $id)->first();

        if($ya){
            $this->dispatch('alerta', name:$this->actual->name. ' Ya tiene asignada esta sede.');
        }else{
            DB::table('sede_user')
            ->insert([
                'user_id'       =>$this->actual->id,
                'sede_id'       =>$id,
                'created_at'    =>now(),
                'updated_at'    =>now(),
            ]);

            $this->dispatch('alerta', name:' Se asigno la sede a: '.$this->actual->name);
        }
    }

    // Eliminar sede elegida
    public function elim($id){
        DB::table('sede_user')->where('user_id',$this->actual->id)->where('sede_id', $id)->delete();
        $this->dispatch('alerta', name:' Se elimino la sede a: '.$this->actual->name);
    }

    public function render()
    {
        return view('livewire.configuracion.user.perfil-sedes');
    }
}
