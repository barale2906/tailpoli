<?php

namespace App\Livewire\Configuracion\Medio;

use App\Traits\CrtStatusTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Medios extends Component
{
    use CrtStatusTrait;

    public $is_crear=true;
    public $name;
    public $id;

    public function crear(){
        DB::table('medios')
            ->insert([
                'name' => strtolower($this->name),
                'created_at'=> now(),
                'updated_at'=> now()
            ]);

        $this->reset('name');
    }

    public function actualizar($id){
        $this->is_crear=false;
        $this->id=$id;
        $ele=DB::table('medios')
                ->where('id', $id)
                ->first();

        $this->name=$ele->name;
    }

    public function editar(){

        DB::table('medios')
            ->where('id', $this->id)
            ->update([
                'name' => strtolower($this->name),
                'updated_at'=> now()
            ]);

        $this->reset('name', 'is_crear');
    }

    public function inactivar($id){
        $ele=DB::table('medios')
                ->where('id', $id)
                ->first();

        if($ele->status){
            DB::table('medios')
                ->where('id', $id)
                ->update([
                    'status' => 0,
                    'updated_at'=> now()
                ]);
        }else{
            DB::table('medios')
                ->where('id', $id)
                ->update([
                    'status' => 1,
                    'updated_at'=> now()
                ]);
        }
    }

    private function medios(){
        return DB::table('medios')
                    ->orderBy('name', 'ASC')
                    ->orderBy('status', 'DESC')
                    ->get();
    }
    public function render()
    {
        return view('livewire.configuracion.medio.medios',[
            'medios'    => $this->medios(),
        ]);
    }
}
