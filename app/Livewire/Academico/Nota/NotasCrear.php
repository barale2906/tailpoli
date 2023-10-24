<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class NotasCrear extends Component
{
    public $actual;
    public $profesor_id;
    public $grupo_id;
    public $grupos;
    public $profesores;
    public $nota;
    public $porcentaje;
    public $cargados=[];
    public $contador=1;
    public $Total=0;
    public $descripcion;
    public $crt=true;
    public $nuevaNota;

    public function mount(){

        $this->actual=Auth::user()->roles[0]['name'];

        $this->profe();
    }

    public function profe(){

        if($this->actual==="Profesor"){
            $this->profesor_id=Auth::user()->id;
            $this->grupoUsu();

        }else{
            $this->profesores();
        }
    }

    private function profesores(){
        $this->profesores = User::where('status', true)
                                ->orderBy('name')
                                ->with('roles')->get()->filter(
                                    fn ($user) => $user->roles->where('name', 'Profesor')->toArray()
                                );
    }

    public function updatedProfesorId(){
        $this->grupoUsu();
    }

    public function updatedGrupoId(){

        $this->reset('crt');
        $hay=Nota::where('profesor_id', $this->profesor_id)
                    ->where('grupo_id', $this->grupo_id)
                    ->count();

        if($hay>0){
            $this->crt=!$this->crt;
        }


    }

    private function grupoUsu(){

        $this->grupos=Grupo::where('status', true)
                            ->where('profesor_id', $this->profesor_id)
                            ->orderBy('name')
                            ->get();

    }

    public function temporal(){

        $porcent=$this->Total+$this->porcentaje;

        if($porcent<=100){
            $nuevo=[
                'contador'=>$this->contador,
                'nota'=>$this->nota,
                'porcentaje'=>$this->porcentaje
            ];

            if(in_array($nuevo, $this->cargados)){

            }else{
                array_push($this->cargados, $nuevo);
                $this->Total=$porcent;
                $this->reset('nota', 'porcentaje');
                $this->contador++;
            }
        }else{
            $this->dispatch('alerta', name:'La suma de los porcentajes no puede ser mayor a 100%');
        }

    }

    public function elimOtro($item){
        foreach ($this->cargados as $value) {
            if($value['contador']===$item){
                $nuevo=[
                    'contador'=>$item,
                    'nota'=>$value['nota'],
                    'porcentaje'=>$value['porcentaje']
                ];
                $this->Total=$this->Total-$value['porcentaje'];

                $indice=array_search($nuevo,$this->cargados,true);
                unset($this->cargados[$indice]);
            }
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'descripcion'=> 'required',
        'grupo_id'=> 'required',
        'profesor_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
        'descripcion',
        'grupo_id',
        'profesor_id'
        );
    }

    public function new(){

        // validate
        $this->validate();

        $numero=1;

        foreach ($this->cargados as $value) {
            $nota="nota".$numero;
            $pocen="porcen".$numero;

            //dd($value,"-",$value['nota'],"-",$value['porcentaje']);

            if($numero===1){
                $this->nuevaNota=Nota::create([
                                        'profesor_id'   =>$this->profesor_id,
                                        'grupo_id'      =>$this->grupo_id,
                                        'descripcion'   =>$this->descripcion,
                                        'nota1'         =>$value['nota'],
                                        'porcen1'       =>$value['porcentaje']
                                    ]);
            }else{
                $this->nuevaNota->update([
                    $nota   =>$value['nota'],
                    $pocen  =>$value['porcentaje']
                ]);
            }

            $numero++;
        }

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la asignación de notas.');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('created');
    }

    public function render()
    {
        return view('livewire.academico.nota.notas-crear');
    }
}
