<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AsignadocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $matriculas = Matricula::where('configpago', 0)
            //->select('id', 'curso_id','sede_id')
            ->get();

        foreach ($matriculas as $matricula) {
            $this->procesarMatricula($matricula,1);
        }

        $this->matriculacontrol();
    }

    private function matriculacontrol(){
        $ids=[];

        $matriculascompletas=Matricula::where('anula_user',null)->get();

        foreach ($matriculascompletas as $value) {
            $esta=Control::where('matricula_id', $value->id)
                            ->count();

            if(intval($esta)===0){
                array_push($ids,$value->id);
            }
        }

        for ($i=0; $i < count($ids); $i++) {
            $matricula=Matricula::find($ids[$i]);
            $this->procesarMatricula($matricula,2);
        }
    }

    private function procesarMatricula($matricula,$act)
    {
        $cartera = $this->obtenerCartera($matricula->id);
        $cuotas = $cartera ? $cartera->count('valor') - 1 : 0;

        if ($this->esMatriculaValida($cartera, $cuotas)) {
            $this->validaCiclo($matricula, $cartera->first());
            if(intval($act)===1){
                $this->asignarConfiguracionCuotas($matricula, $cartera->first(), $cuotas);
            }

        } else {
            $this->validaCiclo($matricula, 1);
            if(intval($act)===1){
                $this->asignarConfiguracionDefault($matricula);
            }
        }
    }

    private function obtenerCartera($matriculaId)
    {
        return Cartera::where('matricula_id', $matriculaId)
                        ->whereIn('concepto_pago_id', [1, 2])
                        ->get();
    }

    private function validaCiclo($matricula,$cartera){
        $estadoCartera=6;
        if($cartera!==1){
            $estadoCartera=$cartera->estado_cartera_id;
        }
        $ciclo=Control::where('matricula_id',$matricula->id)->first();
        if($ciclo){

        }else{
            if($matricula->curso_id===13){
                $cursoid=2;
            }else{
                $cursoid=$matricula->curso_id;
            }
            $elegido=Ciclo::where('sede_id',$matricula->sede_id)
                            ->where('curso_id',$cursoid)
                            ->select('id')
                            ->first();

            if($elegido){
                $ar=Control::create([
                                        'inicia'        =>$matricula->fecha_inicia,
                                        'matricula_id'  =>$matricula->id,
                                        'ciclo_id'      =>$elegido->id,
                                        'sede_id'       =>$matricula->sede_id,
                                        'estudiante_id' =>$matricula->alumno_id,
                                        'estado_cartera'=>$estadoCartera,
                                        'status_est'    =>$matricula->status_est,
                                        'status'        =>0
                                    ]);

                Log::info('NO TENIA CONTROL: Matricula N°:  '. $matricula->id.' Se le asigno el control N°: '.$ar->id);
            }else{
                $this->sinCiclo($matricula,$cursoid,$estadoCartera);

            }
        }
    }

    private function sinCiclo($matricula,$cursoid,$estadoCartera){
        $opcional=Ciclo::where('curso_id',$cursoid)
                        ->select('id')
                        ->inRandomOrder()
                        ->first();

        if($opcional){

            $ar=Control::create([
                            'inicia'        =>$matricula->fecha_inicia,
                            'matricula_id'  =>$matricula->id,
                            'ciclo_id'      =>$opcional->id,
                            'sede_id'       =>$matricula->sede_id,
                            'estudiante_id' =>$matricula->alumno_id,
                            'estado_cartera'=>$estadoCartera,
                            'status_est'    =>$matricula->status_est,
                            'status'        =>0
                        ]);


            Log::info('NO TENIA CONTROL: Matricula N°:  '. $matricula->id.' NO TUBO CONTROL QUE COINCIDIERA. Se le asigno el control N°: '.$ar->id);
        }else{

            Log::info('NO TENIA CONTROL: Matricula N°:  '. $matricula->id.' NO EXISTE CONTROL APLICABLE');
        }
    }

    private function esMatriculaValida($cartera, $cuotas)
    {
        return $cuotas > 0 && $cartera->isNotEmpty();
    }

    private function asignarConfiguracionCuotas($matricula, $primerCartera, $cuotas)
    {
        $config = ConfiguracionPago::where('sector_id', intval($primerCartera->sector_id))
            ->where('curso_id', $matricula->curso_id)
            ->where('cuotas', $cuotas)
            ->first();

        if ($config) {
            $this->actualizarMatricula($matricula->id, $config->id);
        } else {
            $this->asignarConfiguracionAlternativa($matricula);
        }
    }

    private function asignarConfiguracionAlternativa($matricula)
    {
        Log::info('Matricula: No hubo configuración de pago: ' . $matricula->id);

        $configAlternativa = ConfiguracionPago::where('curso_id', $matricula->curso_id)
            ->first();

        if ($configAlternativa) {
            $this->actualizarMatricula($matricula->id, $configAlternativa->id);
        } else {
            Log::info('configuración individual: TOCO MOSTRAR CON VALOR 0: ' . $matricula->id);
        }
    }

    private function asignarConfiguracionDefault($matricula)
    {
        $configContado = ConfiguracionPago::where('curso_id', $matricula->curso_id)
            ->where('cuotas', 0)
            ->first();

        if ($configContado) {
            $this->actualizarMatricula($matricula->id, $configContado->id);
        } else {
            $this->asignarConfiguracionIndividual($matricula);
        }
    }

    private function asignarConfiguracionIndividual($matricula)
    {
        Log::info('Cartera - Cuota: No hubo coincidencia: ' . $matricula->id);

        $configIndividual = ConfiguracionPago::where('curso_id', $matricula->curso_id)
            ->first();

        if ($configIndividual) {
            $this->actualizarMatricula($matricula->id, $configIndividual->id);
        } else {
            Log::info('configuración individual: NO EXISTE CONFIGURACIÓN: ' . $matricula->id);
        }
    }

    private function actualizarMatricula($matriculaId, $configId)
    {
        Matricula::where('id', $matriculaId)
            ->update(['configpago' => $configId]);
    }
}
