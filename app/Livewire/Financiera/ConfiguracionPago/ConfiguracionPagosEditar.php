<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ConfiguracionPagosEditar extends Component
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
    public $id;
    public $modulos;

    public $moduloDepen=[];

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
        'sector_id'             => 'required|integer',
        'curso_id'              => 'required|integer'
    ];

    public function updatedFinaliza(){
        if($this->finaliza<$this->inicia){
            $this->dispatch('alerta', name:'Finalización debe ser mayor a inicio');
            $this->reset('finaliza');
        }
    }

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

    public function mount($elegido = null)
    {
        $this->inicia=$elegido['inicia'];
        $this->finaliza=$elegido['finaliza'];
        $this->valor_curso=$elegido['valor_curso'];
        $this->valor_matricula=$elegido['valor_matricula'];
        $this->cuotas=$elegido['cuotas'];
        $this->valor_cuota=$elegido['valor_cuota'];
        $this->descripcion=$elegido['descripcion'];
        $this->sector_id=$elegido['sector_id'];
        $this->curso_id=$elegido['curso_id'];
        $this->id=$elegido['id'];

        if(!$elegido['incluye']){
            $this->cargaDep();
        }

        $this->buscaModulos();
    }

    //Carga dependencias
    public function cargaDep(){
        $registros=DB::table('configpago_modulo')
                        ->where('config_id', $this->id)
                        ->get();

        foreach ($registros as $value){
            $nuevo=[
                'id'=>$value->modulo_id,
                'name'=>$value->name
            ];

            if(in_array($nuevo, $this->moduloDepen)){

            }else{
                array_push($this->moduloDepen, $nuevo);
            }
        }

    }

    //Cambia valor curso
    public function updatedValorCurso(){
        $this->recalcular();
    }

    //Cambia valor matricula
    public function updatedValorMatricula(){
        $this->recalcular();
    }

    //Recalcular
    public function recalcular(){
        $this->calcuCuota();
        $this->calcula();
    }

    //Cambiar curso
    public function updatedCursoId(){
        $this->reset('moduloDepen');
        $this->buscaModulos();
    }

    //Busca modulos
    public function buscaModulos(){
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

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //eliminar dependencias actuales
        DB::table('configpago_modulo')
            ->where('config_id', $this->id)
            ->delete();

        if($this->valor_matricula===0){
            $this->valor_matricula=$this->valor_curso;
        }

        // Verifica inclusión
        if(count($this->moduloDepen)>0){

            //Editar registro
            ConfiguracionPago::whereId($this->id)->update([
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
                            'config_id'     =>$this->id,
                            'modulo_id'     =>$value['id'],
                            'name'          =>$value['name'],
                            'created_at'    =>now(),
                            'updated_at'    =>now(),
                        ]);
                }

        }else{
            ConfiguracionPago::whereId($this->id)->update([
                'inicia'=>$this->inicia,
                'finaliza'=>$this->finaliza,
                'valor_curso'=>$this->valor_curso,
                'valor_matricula'=>$this->valor_matricula,
                'cuotas'=>$this->cuotas,
                'valor_cuota'=>$this->valor_cuota,
                'descripcion'=>$this->descripcion,
                'sector_id'=>$this->sector_id,
                'curso_id'=>$this->curso_id,
                'incluye'=>true
            ]);
        }

        $this->dispatch('alerta', name:'Se ha modificado correctamente la configuración de pago ');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
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

    public function render()
    {
        return view('livewire.financiera.configuracion-pago.configuracion-pagos-editar', [
            'ciudades'=>$this->ciudades(),
            'cursos'=>$this->cursos()
        ]);
    }
}
