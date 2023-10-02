<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Support\Facades\Auth;
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
    public function buscaModulos(){
        $this->modulos=Modulo::where('curso_id', $this->curso_id)
                                ->where('status', true)
                                ->orderBy('name')
                                ->get();
    }

    //Activa cuotas
    public function calcuCuota(){
        if($this->valor_curso>$this->valor_cuota_inicial){
            $this->saldo=$this->valor_curso-$this->valor_matricula-$this->valor_cuota_inicial;
        }

        if($this->valor_curso===$this->valor_cuota_inicial){
            $this->valor_cuota=0;
            $this->cuotas=0;
        }
        if($this->valor_curso<$this->valor_cuota_inicial){
            $this->dispatch('alerta', name:'La cuota inicial debe ser menor al valor del curso.');
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

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();


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
