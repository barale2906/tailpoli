<?php

namespace App\Livewire\Academico\Modulo;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModulosCrear extends Component
{
    public $name = '';
    public $curso_id = '';
    public $cursodet;
    public $mostrar=false;
    public $moduloDepen=[];

    public function curso(){
        $this->cursodet=Curso::find($this->curso_id);
        $this->mostrar=true;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'curso_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'curso_id');
    }

    //Elegir los modulos de los cuales depende
    public function selModulo($id){

        foreach ($this->cursodet->modulos as $value) {
            if($value->id===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value->name
                ];

                if(in_array($nuevo, $this->moduloDepen)){

                }else{
                    array_push($this->moduloDepen, $nuevo);
                }

            };

        }
    }

    // Eliminar modulo elegido
    public function elimModulo($id){
        foreach ($this->cursodet->modulos as $value) {
            if($value->id===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value->name
                ];
            }
        }
        $indice=array_search($nuevo,$this->moduloDepen,true);
        unset($this->moduloDepen[$indice]);
    }

    // Crear
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Modulo::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este modulo: '.$this->name);
        } else {

            //Verificar si hay dependencias
            if(count($this->moduloDepen)>0){

                //Crear registro
                $mod = Modulo::create([
                    'name'=>strtolower($this->name),
                    'curso_id'=>strtolower($this->curso_id),
                    'dependencia'=>true
                ]);

                foreach ($this->moduloDepen as $value) {
                    DB::table('modulos_dependencias')
                        ->insert([
                            'modulo_id'     =>$mod->id,
                            'modulodep_id'  =>$value['id'],
                            'created_at'    =>now(),
                            'updated_at'    =>now(),
                        ]);
                }
            }else{
                Modulo::create([
                    'name'=>strtolower($this->name),
                    'curso_id'=>strtolower($this->curso_id)
                ]);
            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el modulo: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    private function cursos()
    {
        return Curso::where('status', '=', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.modulo.modulos-crear', [
            'cursos' => $this->cursos()
        ]);
    }
}
