<?php

namespace App\Livewire\Academico\Modulo;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModulosEditar extends Component
{
    public $name = '';
    public $curso_id = '';
    public $id = '';
    public $moduloDepen=[];
    public $cursodet;
    public $dependencia;
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'id'    => 'required',
        'curso_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'curso_id');
    }

    public function mount($elegido = null){
        $this->name=$elegido['name'];
        $this->curso_id=$elegido['curso_id'];
        $this->dependencia=$elegido['dependencia'];
        $this->id=$elegido['id'];

        $this->curso();

        if($elegido['dependencia']){
            $this->cargaDep();
        }
    }

    public function cargaDep(){
        $registros=DB::table('modulos_dependencias')
                        ->where('modulo_id', $this->id)
                        ->join('modulos', 'modulos_dependencias.modulodep_id', '=', 'modulos.id')
                        ->get();

        foreach ($registros as $value){
            $nuevo=[
                'id'=>$value->modulodep_id,
                'name'=>$value->name
            ];

            if(in_array($nuevo, $this->moduloDepen)){

            }else{
                array_push($this->moduloDepen, $nuevo);
            }
        }

    }

    public function curso(){
        $this->cursodet=Curso::find($this->curso_id);
        $this->reset('moduloDepen');
    }

    //Actualizar Regimen de Salud
    public function edit(){
        // validate
        $this->validate();

        //eliminar dependencias actuales
        DB::table('modulos_dependencias')
            ->where('modulo_id', $this->id)
            ->delete();

        //Verificar si hay dependencias
        if(count($this->moduloDepen)>0){

            //Actualizar registro
            Modulo::whereId($this->id)->update([
                                'name'=>strtolower($this->name),
                                'curso_id'=>$this->curso_id,
                                'dependencia'=>true
                            ]);

            foreach ($this->moduloDepen as $value){
                DB::table('modulos_dependencias')
                    ->insert([
                        'modulo_id'     =>$this->id,
                        'modulodep_id'  =>$value['id'],
                        'created_at'    =>now(),
                        'updated_at'    =>now(),
                    ]);
            }
        }else{
            Modulo::whereId($this->id)->update([
                        'name'=>strtolower($this->name),
                        'curso_id'=>$this->curso_id,
                        'dependencia'=>false
                    ]);
        }

        $this->dispatch('alerta', name:'Se ha modificado correctamente el modulo: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
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

    private function cursos(){
        return Curso::where('status', '=', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.modulo.modulos-editar', [
            'cursos' => $this->cursos()
        ]);
    }
}
