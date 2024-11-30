<?php

namespace App\Livewire\Configuracion\Docugrado;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Docugrado;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Cargaregistros extends Component
{
    use WithFileUploads;

    public $archivo;
    public $ruta;
    public $crterrores=[];
    public $is_errores=false;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'archivo'   => 'required|mimes:csv',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'archivo',
        );
    }

    public function cargar(){

        // validate
        $this->validate();

        $this->reset('crterrores','is_errores');

        $this->ruta='graduandos/'.uniqid().".".$this->archivo->extension();
        $this->archivo->storeAs($this->ruta);

        $this->cargarch();


    }

    private function cargarch(){
        $row = 0;
        $observaciones=now().": ".Auth::user()->name." Cargo los estudiantes.";

        if(($handle = fopen(Storage::path($this->ruta), 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    $matricula=Matricula::find(intval($data[0]));



                    Docugrado::create([

                                'matricula_id'=>$matricula->id,
                                'graduando_id'=>$matricula->alumno_id,
                                'titulo'=>strtolower($data[1]),
                                'tipo_curso'=>$data[2],
                                'fecha_grado'=>$data[3],
                                'acta'=>$data[4],
                                'fecha_acta'=>$data[5],
                                'alumnos_graduados'=>$data[6],
                                'alumno_inicia'=>strtolower($data[7]),
                                'alumno_finaliza'=>strtolower($data[8]),
                                'folio_acta'=>$data[9],
                                'libro'=>$data[10],
                                'observaciones'=>$observaciones,
                                'user_gestiona'=>Auth::user()->id

                    ]);

                }catch(Exception $exception){
                    //Log::info('Line: ' . $row . ' '.$this->ruta.' with error: ' . $exception->getMessage().' real: '.$data[1]);
                    $errorMessage = $exception->getMessage();
                    $cleanMessage = preg_replace("/\(Connection:.*$/", "", $errorMessage);
                    $error=$cleanMessage.' numero de línea: '.$row;
                    array_push($this->crterrores,$error);
                }
            }

            fclose($handle);

            // Elimina el archivo después de procesarlo
            Storage::delete($this->ruta);
            Log::info('Archivo eliminado: ' . $this->ruta);
        } else {
            Log::error('No se pudo abrir el archivo en la ruta: ' . Storage::path($this->ruta));
        }

        if(count($this->crterrores)>0){
            $this->dispatch('alerta', name:'Se presentaron errores al cargar, valide los datos');
            $this->is_errores=true;
        }else{
            // Notificación
            $this->dispatch('alerta', name:'Se ha cargado correctamente los registros');
        }

        $this->resetFields();
    }

    public function render()
    {
        return view('livewire.configuracion.docugrado.cargaregistros');
    }
}
