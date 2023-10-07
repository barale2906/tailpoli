<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ConfiguracionPagosCrear extends Component
{
    public $valor_curso;
    public $valor_matricula;
    public $valor_cuota_inicial;
    public $saldo;
    public $cuotas;
    public $valor_cuota;
    public $descripcion;
    public $sede_id;
    public $curso_id;
    public $modulos;

    public $moduloDepen=[];

    /**
     * Reglas de validación
     */
    protected $rules = [
        'valor_curso' => 'required|min:1',
        'valor_matricula' => 'required|min:1',
        'valor_cuota_inicial'=> 'required|min:1',
        'cuotas'=> 'required|integer',
        'valor_cuota'=> 'required|min:1',
        'descripcion'=> 'required',
        'sede_id'=> 'required|integer',
        'curso_id'=> 'required|integer'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'valor_curso',
                        'valor_matricula',
                        'valor_cuota_inicial',
                        'cuotas',
                        'valor_cuota',
                        'descripcion',
                        'sede_id',
                        'curso_id',
                        'saldo'
                    );
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

        if($this->valor_matricula===''){
            $this->valor_matricula=0;
        }

        if($this->valor_cuota_inicial===''){
            $this->valor_cuota_inicial=0;
        }

        $diferencia=$this->valor_cuota_inicial+$this->valor_matricula;

        if($this->valor_curso>$diferencia){
            $this->saldo=$this->valor_curso-$diferencia;
        }

        if($this->valor_curso===$diferencia){
            $this->valor_cuota=0;
            $this->cuotas=0;
        }

        if($this->valor_curso<$diferencia){
            $this->dispatch('alerta', name:'La cuota inicial/matricula debe ser menor al valor del curso.');
            $this->reset(
                'cuotas',
                'valor_cuota',
            );
        }
    }

    // Calculo de las cuotas
    public function calcula(){
        if($this->cuotas>0 && $this->valor_curso>$this->valor_cuota_inicial){
            $saldo = $this->valor_curso-$this->valor_matricula-$this->valor_cuota_inicial;
            $this->valor_cuota=$saldo/$this->cuotas;
        }
    }

    //Elegir los modulos incluidos
    public function selModulo($id){

        foreach ($this->modulos as $value) {
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
        foreach ($this->modulos as $value) {
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

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        if($this->valor_matricula===0 && $this->valor_cuota_inicial){
            $this->valor_matricula=$this->valor_curso;
        }
        // Verifica inclusión
        if(count($this->moduloDepen)>0){

            //Crear registro
            $nuevo = ConfiguracionPago::create([
                                            'valor_curso'=>$this->valor_curso,
                                            'valor_matricula'=>$this->valor_matricula,
                                            'valor_cuota_inicial'=>$this->valor_cuota_inicial,
                                            'cuotas'=>$this->cuotas,
                                            'valor_cuota'=>$this->valor_cuota,
                                            'descripcion'=>$this->descripcion,
                                            'sede_id'=>$this->sede_id,
                                            'curso_id'=>$this->curso_id,
                                            'incluye'=>false
                                        ]);

            foreach ($this->moduloDepen as $value) {
                    DB::table('configpago_modulo')
                        ->insert([
                            'config_id'     =>$nuevo->id,
                            'modulo_id'     =>$value['id'],
                            'name'          =>$value['name'],
                            'created_at'    =>now(),
                            'updated_at'    =>now(),
                        ]);
                }

        }else{
            //Crear registro
            ConfiguracionPago::create([

                'valor_curso'=>$this->valor_curso,
                'valor_matricula'=>$this->valor_matricula,
                'valor_cuota_inicial'=>$this->valor_cuota_inicial,
                'cuotas'=>$this->cuotas,
                'valor_cuota'=>$this->valor_cuota,
                'descripcion'=>$this->descripcion,
                'sede_id'=>$this->sede_id,
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

    private function sedes(){
        return Sede::query()
                    ->with(['users'])
                    ->when(Auth::user()->id, function($qu){
                        return $qu->where('status', true)
                                ->whereHas('users', function($q){
                                    $q->where('user_id', Auth::user()->id);
                                });
                    })
                    ->orderBy('name')
                    ->get();
    }

    private function cursos(){
        return Curso::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.financiera.configuracion-pago.configuracion-pagos-crear', [
            'sedes'=>$this->sedes(),
            'cursos'=>$this->cursos()
        ]);
    }
}
