<?php

namespace App\Livewire\Financiera\ReciboPago;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\EstadoCartera;
use App\Models\Financiera\ReciboPago;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RecibosPagoCrear extends Component
{
    public $medio='';
    public $observaciones='';
    public $sede_id;
    public $cargados;
    public $tipo;
    public $saldo;
    public $id_cartera;
    public $estado;


    public $valor=0;
    public $conceptos=0;
    public $concep=[];
    public $nameConcep='';
    public $Total=0;
    public $control=[];

    public $otrosDeta=array();

    public $buscar=null;
    public $buscaestudi='';

    public $alumno_id='';
    public $alumnoName='';
    public $alumnodocumento='';

    public $pendientes;

    public function mount(){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
    }

    #[On('cargados')]
    //obtener itemes cargados
    public function cargando(){
        $this->cargados=DB::table('apoyo_recibo')
                            ->where('id_creador', Auth::user()->id)
                            ->orderBy('tipo')
                            ->get();
    }

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
                                ->orderBy('fecha_pago')
                                ->get();
    }

    public function asigOtro($id, $item){
        switch ($id) {
            case 0:
                $this->tipo="otro";
                break;

            case 1:
                $this->tipo="cartera";
                $this->saldo=$item['saldo'];
                $this->id_cartera=$item['id'];
                break;

            default:
                $this->tipo="inventario";
                break;
        }
        if($this->valor>0){
            foreach ($this->concep as $value) {

                if($value['id']===intval($this->conceptos)){

                    DB::table('apoyo_recibo')->insert([
                        'tipo'=>$this->tipo,
                        'id_creador'=>Auth::user()->id,
                        'id_concepto'=>$this->conceptos,
                        'concepto'=>$value['name'],
                        'valor'=>$this->valor,
                        'saldo'=>$this->saldo,
                        'id_cartera'=>$this->id_cartera
                    ]);

                    $this->Total=$this->Total+$this->valor;

                    $this->reset(
                                'valor' ,
                                'conceptos',
                                'name'
                                );

                    $this->cargando();
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

    public function elimOtro($item, $valor){

        DB::table('apoyo_recibo')
            ->where('id', $item)
            ->delete();

        $this->Total=$this->Total-$valor;

        $this->cargando();
    }




    /**
     * Reglas de validación
     */
    protected $rules = [
        'medio'=>'required',
        'observaciones'=>'required',
        'sede_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                    'medio',
                    'observaciones',
                    'sede_id'
                    );
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        $recibo= ReciboPago::create([
                                'fecha'=>now(),
                                'valor_total'=>$this->Total,
                                'medio'=>$this->medio,
                                'observaciones'=>strtolower($this->observaciones),
                                'sede_id'=>$this->sede_id,
                                'creador_id'=>Auth::user()->id,
                                'paga_id'=>$this->alumno_id
                            ]);

        //registros

        foreach ($this->cargados as $value) {

            DB::table('concepto_pago_recibo_pago')
            ->insert([
                'valor'=>$value->valor,
                'tipo'=>$value->tipo,
                'conceptos_id'=>$value->id_concepto,
                'recibo_id'=>$recibo->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);

            if($value->tipo==="cartera"){

                $item=Cartera::find($value->id_cartera);
                $saldo=$item->saldo-$value->saldo;
                dd($item->saldo, $value->saldo, $saldo);
                $observa=now()." ".$this->alumnoName." realizo pago por ".number_format($value->valor, 0, ',', '.').", con el recibo N°: ".$recibo->id.". --- ".$item->observaciones;
                if($saldo===0){
                    $esta=EstadoCartera::where('name', 'cerrada')->first();
                    $this->estado=$esta->id;
                    dd($esta->id);
                }else if($saldo>0){
                    $esta=EstadoCartera::where('name', 'abonada')->first();
                    $this->estado=$esta->id;
                }

                $item->update([
                    'fecha_real'=>now(),
                    'saldo'=>$saldo,
                    'observaciones'=>$observa,
                    'status'=>$this->estado
                ]);
            }

        }
        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el recibo: '.$recibo->id);
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

    public function render(){
        return view('livewire.financiera.recibo-pago.recibos-pago-crear',[
            'sedes'=>$this->sedes(),
            'estudiantes'=>$this->estudiantes(),
            'concePagos'=>$this->concePagos()
        ]);
    }
}
