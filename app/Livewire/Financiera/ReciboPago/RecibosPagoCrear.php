<?php

namespace App\Livewire\Financiera\ReciboPago;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RecibosPagoCrear extends Component
{
    public $fecha = '';
    public $valor_total = '';
    public $medio='';
    public $observaciones='';
    public $sede_id;
    public $crea_id;
    public $paga_id;

    public $valor=0;
    public $conceptos=0;
    public $concep=[];
    public $nameConcep='';
    public $Total=0;
    public $detalles=[];
    public $control=[];

    public $otrosDeta=[];

    public $buscar=null;
    public $buscaestudi='';

    public $alumno_id='';
    public $alumnoName='';
    public $alumnodocumento='';

    public $pendientes;

    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscar');
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->alumnodocumento=$item['documento'];
        $this->obligaciones();
    }

    public function obligaciones(){
        $this->pendientes= Cartera::where('responsable_id', $this->alumno_id)
                                ->where('status', true)
                                ->get();
    }

    public function asignar($item){

        if($item['saldo']>=$this->valor && $this->valor>0){
            if(in_array([
                'id'=>$item['id'],
                'saldo'=>$item['saldo']
            ], $this->control))
            {
                $this->dispatch('alerta', name:'Item ya cargado');
            }else{
                $nuevo=[
                    'id'=>$item['id'],
                    'saldo'=>$item['saldo'],
                    'fecha_pago'=>$item['fecha_pago'],
                    'concepto'=>$this->conceptos,
                    'valor'=>$this->valor
                ];
                $crt=[
                    'id'=>$item['id'],
                'saldo'=>$item['saldo']
                ];
                array_push($this->detalles,$nuevo);
                array_push($this->control,$crt);
                $this->Total=$this->Total+$this->valor;
                $this->valor=0;
            }
        }else{
            $this->dispatch('alerta', name:'El valor debe ser mayor a 0 y menor al saldo');
        }

    }

    public function asigOtro(){
        if($this->valor>0){
            foreach ($this->concep as $value) {

                if($value['id']===intval($this->conceptos)){
                    $nuevo=[
                        'concepto'=>$this->conceptos,
                        'name'=>$value['name'],
                        'valor'=>$this->valor
                    ];
                    array_push($this->otrosDeta,$nuevo);

                    $this->Total=$this->Total+$this->valor;

                    $this->reset(
                                'valor' ,
                                'conceptos',
                                'name'
                                );

                    $this->dispatch('alerta', name:'CARGADO');
                }
            }
        }else{
            $this->dispatch('alerta', name:'VALOR Mayor que cero');
            $this->reset(
                'valor' ,
                'conceptos',
                'name'
                );
        }

    }

    public function elimOtro($item){
        dd($item);

        $this->dispatch('alerta', name:'ELIMINIAR '.$item['name']);

        /* $textos = array("Hola", "Chau", "Bien", "Mal");

        echo "Borrando la palabra 'Chau' dentro del array:<br>";
        if (($clave = array_search("Chau", $textos)) !== false) {
            unset($textos[$clave]);
            print_r($textos);
        } */
    }



    /**
     * Reglas de validación
     */
    protected $rules = [
        'fecha' => 'required',
        'valor_total'=>'required',
        'medio'=>'required',
        'observaciones'=>'required',
        'sede_id'=>'required',
        'crea_id'=>'required',
        'paga_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                    'fecha' ,
                    'valor_total',
                    'medio',
                    'observaciones',
                    'sede_id',
                    'crea_id',
                    'paga_id'
                    );
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        ReciboPago::create([
            'fecha'=>$this->fecha,
            'valor_total'=>$this->valor_total,
            'medio'=>$this->medio,
            'observaciones'=>strtolower($this->observaciones),
            'sede_id'=>$this->sede_id,
            'crea_id'=>$this->crea_id,
            'paga_id'=>$this->paga_id
        ]);

        //registros
        $a=0;
        /*  while ($a <= count($this->valor)) {
            DB::table('concepto_pago_recibo_pago')
            ->insert([
                'valor'=>$item,
                'cartera_id'=>$this->cartera_id[],
                'conceptos_id',
                'recibos_id',
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
            $a++;
        }
 */
        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el recibo: '.$this->name);
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

    private function estudiantes(){
        return User::where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('documento', 'like', "%".$this->buscaestudi."%")
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                        );
    }

    private function concePagos(){
        $this->concep=ConceptoPago::where('status', true)
                            ->orderBy('name')
                            ->get();

        return $this->concep;
    }

    public function render()
    {
        return view('livewire.financiera.recibo-pago.recibos-pago-crear',[
            'sedes'=>$this->sedes(),
            'estudiantes'=>$this->estudiantes(),
            'concePagos'=>$this->concePagos()
        ]);
    }
}
