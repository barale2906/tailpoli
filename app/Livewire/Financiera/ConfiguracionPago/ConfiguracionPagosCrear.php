<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sector;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ConfiguracionPagosCrear extends Component
{
    public $inicia;
    public $finaliza;
    public $valor_curso;
    public $valor_matricula;
    public $saldo;
    public $cuotas;
    public $valor_cuota;
    public $descripcion;
    public $sector_id;
    public $curso_id;
    public $modulos;

    public $moduloDepen=[];

    public $contado=true;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'inicia'                => 'required',
        'finaliza'              => 'required',
        'valor_curso'           => 'required|min:1',
        'valor_matricula'       => 'required|min:1',
        'cuotas'                => 'required|integer',
        'valor_cuota'           => 'required|min:1',
        'descripcion'           => 'required',
        'sector_id'               => 'required|integer',
        'curso_id'              => 'required|integer'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'inicia',
                        'finaliza',
                        'valor_curso',
                        'valor_matricula',
                        'cuotas',
                        'valor_cuota',
                        'descripcion',
                        'sector_id',
                        'curso_id',
                        'saldo'
                    );
    }

    public function updatedContado(){
        if($this->contado){
            $this->valor_matricula=$this->valor_curso;
            $this->cuotas=0;
            $this->valor_cuota=0;
        }
    }

    public function updatedFinaliza(){
        if($this->finaliza<$this->inicia){
            $this->dispatch('alerta', name:'Finalización debe ser mayor a inicio');
            $this->reset('finaliza');
        }
    }

    //Busca modulos
    public function updatedCursoId(){
        $this->modulos=Modulo::where('curso_id', $this->curso_id)
                                ->where('status', true)
                                ->orderBy('name')
                                ->get();
    }

    //Activa cuotas
    public function calcuCuota(){

        if($this->valor_curso>$this->valor_matricula){
            $this->saldo=$this->valor_curso-$this->valor_matricula;
        }

        if($this->valor_curso<$this->valor_matricula){
            $this->dispatch('alerta', name:'La matricula debe ser menor al valor del curso.');
            $this->reset(
                'cuotas',
                'valor_cuota',
            );
        }
    }

    // Calculo de las cuotas
    public function calcula(){
        if($this->cuotas>0 && $this->valor_curso>$this->valor_matricula){
            $saldo = $this->valor_curso-$this->valor_matricula;
            $this->valor_cuota=$saldo/$this->cuotas;
            $this->redondear();
        }
    }

    public function redondear(){
        $this->valor_cuota=intval($this->valor_cuota);
        $diferencia=$this->valor_cuota % 1000;
        $this->valor_cuota=$this->valor_cuota-$diferencia;
    }

    //Elegir los modulos incluidos
    public function selModulo($id){

        foreach ($this->modulos as $value) {
            if($value->id===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value->name,
                    'dependencia'=>$value->dependencia
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
        foreach ($this->modulos as $value) {
            if($value->id===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value->name,
                    'dependencia'=>$value->dependencia,
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

        if($this->valor_matricula===0){
            $this->valor_matricula=$this->valor_curso;
        }
        // Verifica inclusión
        if(count($this->moduloDepen)>0){

            //Crear registro
            $nuevo = ConfiguracionPago::create([
                                            'inicia'=>$this->inicia,
                                            'finaliza'=>$this->finaliza,
                                            'valor_curso'=>$this->valor_curso,
                                            'valor_matricula'=>$this->valor_matricula,
                                            'cuotas'=>$this->cuotas,
                                            'valor_cuota'=>$this->valor_cuota,
                                            'descripcion'=>$this->descripcion,
                                            'sector_id'=>$this->sector_id,
                                            'curso_id'=>$this->curso_id,
                                            'incluye'=>false
                                        ]);

            foreach ($this->moduloDepen as $value) {
                    DB::table('configpago_modulo')
                        ->insert([
                            'config_id'     =>$nuevo->id,
                            'modulo_id'     =>$value['id'],
                            'name'          =>$value['name'],
                            'dependencia'   =>$value['dependencia'],
                            'created_at'    =>now(),
                            'updated_at'    =>now(),
                        ]);
                }

        }else{
            //Crear registro
            ConfiguracionPago::create([
                'inicia'=>$this->inicia,
                'finaliza'=>$this->finaliza,
                'valor_curso'=>$this->valor_curso,
                'valor_matricula'=>$this->valor_matricula,
                'cuotas'=>$this->cuotas,
                'valor_cuota'=>$this->valor_cuota,
                'descripcion'=>$this->descripcion,
                'sector_id'=>$this->sector_id,
                'curso_id'=>$this->curso_id
            ]);

        }


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la configuración de pago: ');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('created');
    }

    private function ciudades(){
        return Sector::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function cursos(){
        return Curso::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render(){
        return view('livewire.financiera.configuracion-pago.configuracion-pagos-crear', [
            'ciudades'=>$this->ciudades(),
            'cursos'=>$this->cursos()
        ]);
    }
}
