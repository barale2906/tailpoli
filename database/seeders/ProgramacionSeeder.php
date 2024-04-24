<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Area;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgramacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/23-ciclosfinales.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        if(intval($data[0]) && intval($data[1])){

                            $cursosel=Curso::where('id', intval($data[0]))
                                            ->select('name')
                                            ->first();

                            $modulos=Modulo::where('curso_id', intval($data[0]))
                                            ->where('status', true)
                                            ->select('id', 'name')
                                            ->get();

                            $sedesel=Sede::where('id', intval($data[1]))
                                            ->select('name','sector_id')
                                            ->first();

                            $sectorsel=Sector::where('id', $sedesel->sector_id)
                                            ->select('name')
                                            ->first();

                            $sede=explode(" ",$sedesel->name);
                            $ciudad=explode(" ",$sectorsel->name);
                            $curso=explode(" ",$cursosel->name);


                            $sedeBase="";

                            for ($i=0; $i < count($sede); $i++) {

                                $lon=strlen($sede[$i]);


                                if($lon>3){
                                    $text=substr($sede[$i], 0, 4);
                                    $sedeBase=$sedeBase."-".$text;
                                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                                }else{
                                    $text=substr($sede[$i], 0, $lon);
                                    $sedeBase=$sedeBase."-".$text;
                                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                                }
                            }

                            $ciudadBase="";

                            for ($i=0; $i < count($ciudad); $i++) {

                                $lon=strlen($ciudad[$i]);


                                if($lon>3){
                                    $text=substr($ciudad[$i], 0, 4);
                                    $ciudadBase=$ciudadBase."-".$text;
                                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                                }else{
                                    $text=substr($ciudad[$i], 0, $lon);
                                    $ciudadBase=$ciudadBase."-".$text;
                                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                                }
                            }

                            $cursoBase="";

                            for ($i=0; $i < count($curso); $i++) {

                                $lon=strlen($curso[$i]);


                                if($lon>3){
                                    $text=substr($curso[$i], 0, 4);
                                    $cursoBase=$cursoBase."-".$text;
                                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                                }else{
                                    $text=substr($curso[$i], 0, $lon);
                                    $cursoBase=$cursoBase."-".$text;
                                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                                }
                            }

                            $name=$cursosel->name." -- ".$data[5]." -- ".$data[2]." -- ".$sedeBase." -- ".$ciudadBase;


                            $ini=new Carbon($data[2]);
                            $fin=$ini->addMonths($data[3]);

                            //Crear ciclo
                            $ciclo=Ciclo::create([
                                'curso_id'      =>intval($data[0]),
                                'sede_id'       =>intval($data[1]),
                                'name'          =>$name,
                                'inicia'        =>$data[2],
                                'finaliza'      =>$fin,
                                'jornada'       =>$data[4],
                                'desertado'     =>$data[6]
                            ]);

                            //Crear Grupos
                            $nombregrupo=' -- '.$data[5]." - ".$data[7]." - ".$data[9].$sedeBase.$cursoBase;

                            $imod=0;

                            $ultimodulo=$modulos->count()-1;

                            foreach ($modulos as $value) {

                                $nomGru=$value->name.$nombregrupo;

                                $existe=Grupo::where('name', $nomGru)->count();

                                if($existe===0){
                                    $grupo= Grupo::create([
                                        'name'              =>$nomGru,
                                        'quantity_limit'    =>100,
                                        'modulo_id'         =>$value->id,
                                        'sede_id'           =>$data[1],
                                        'profesor_id'       =>453
                                        ]);

                                    //Area
                                    $area=Area::where('name', $data[8])->select('id')->first();

                                    //0btener días
                                    $dias=array();

                                    if($data[11]==="1"){
                                        array_push($dias,'lunes');
                                    }
                                    if($data[12]==="1"){
                                        array_push($dias,'martes');
                                    }
                                    if($data[13]==="1"){
                                        array_push($dias,'miercoles');
                                    }
                                    if($data[14]==="1"){
                                        array_push($dias,'jueves');
                                    }
                                    if($data[15]==="1"){
                                        array_push($dias,'viernes');
                                    }
                                    if($data[16]==="1"){
                                        array_push($dias,'sabado');
                                    }
                                    if($data[17]==="1"){
                                        array_push($dias,'domingo');
                                    }

                                    //Horarios
                                    foreach ($dias as $val) {

                                        $cant=intval($data[10]);

                                        for ($is=0; $is < $cant; $is++) {

                                            //Calcular horas
                                            $inih=new Carbon($data[9]);
                                            $horac=$inih->addHours($is);
                                            $hora=$horac->roundMinutes(60)->format('H:i:s');

                                            //Log::info('fila: ' . $row . ' 23-ciclosfinales id dia: ' . $is.' horario inicio: '.$inih.' campo inicia: '. $hora);

                                            Horario::create([
                                                'sede_id'       =>intval($data[3]),
                                                'area_id'       =>$area->id,
                                                'grupo'         =>$grupo->name,
                                                'grupo_id'      =>$grupo->id,
                                                'tipo'          =>false,
                                                'periodo'       =>true,
                                                'dia'           =>$val,
                                                'hora'          =>$hora,
                                            ]);
                                        }
                                    }

                                }else{
                                    $grupo=Grupo::where('name', $nomGru)->select('id')->first();
                                }

                                //Franja de modulos
                                $franja=intval($data[3])*30/$modulos->count();
                                $duracion=new Carbon($data[2]);
                                $rango=$franja*$imod;
                                $periodo=$duracion->addDays($rango);
                                $fecha_inicio=$periodo;


                                $inicicl=new Carbon($data[2]);
                                $fincicl=$inicicl->addMonths($data[3]);
                                $inidef=new Carbon($data[2]);

                                //Actualizar fecha fin
                                $ultimo=Ciclogrupo::orderBy('id', 'DESC')->first();
                                $ultimo->update([
                                    'fecha_fin'=>$fecha_inicio,
                                ]);


                                //Crear nuevo
                                if($imod===0){
                                    Ciclogrupo::create([
                                        'ciclo_id'       => $ciclo->id,
                                        'grupo_id'       => $grupo->id,
                                        'fecha_inicio'   => $inidef,
                                        'fecha_fin'      => $fecha_inicio,
                                    ]);
                                }else if($imod===$ultimodulo) {
                                    Ciclogrupo::create([
                                        'ciclo_id'       => $ciclo->id,
                                        'grupo_id'       => $grupo->id,
                                        'fecha_inicio'   => $fecha_inicio,
                                        'fecha_fin'      => $fincicl,
                                    ]);
                                }else{
                                    Ciclogrupo::create([
                                        'ciclo_id'       => $ciclo->id,
                                        'grupo_id'       => $grupo->id,
                                        'fecha_inicio'   => $fecha_inicio,
                                        'fecha_fin'      => $fecha_inicio,
                                    ]);
                                }

                                //Log::info('fila: ' . $row . ' 23-ciclosfinales iden: ' . $imod.' inicia: '.$inidef.' finaliza: '. $fincicl.' fecha ini '.$fecha_inicio.' fecha fin '.$fecha_inicio);

                                $imod++;
                            }
                        }

                    }catch(Exception $exception){
                        Log::info('fila: ' . $row . ' 23-ciclosfinales with error: ' . $exception->getMessage().' linea código: '.$exception->getLine() );
                    }

                }
        }

        fclose($handle);
    }
}
