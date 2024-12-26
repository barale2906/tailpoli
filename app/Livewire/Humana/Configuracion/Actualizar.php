<?php

namespace App\Livewire\Humana\Configuracion;

use App\Models\Admin\RegimenSalud;
use App\Models\Configuracion\Perfil;
use App\Traits\CrtStatusTrait;
use App\Traits\FuncionariosTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Actualizar extends Component
{
    use FuncionariosTrait;
    use CrtStatusTrait;

    public $actual;
    public $cargo;
    public $tipo_contrato;
    public $educacion;
    public $contrato;
    public $salario;
    public $fecha_inicio;
    public $fecha_fin;
    public $fecha_otrosi;
    public $carta_finaliza;
    public $banco;
    public $cuenta;
    public $arl;
    public $porcen_arl;
    public $pension;
    public $eps;
    public $caja;
    public $dotacion;
    public $nacimiento;
    public $observaciones;



    public function mount($elegido){
        $this->detalle($elegido);
        $this->valores();
    }

    public function valores(){
        $this->cargo=$this->actual->cargo;
        $this->tipo_contrato=$this->actual->tipo_contrato;
        $this->educacion=$this->actual->educacion;
        $this->contrato=$this->actual->contrato;
        $this->salario=$this->actual->salario;
        $this->fecha_inicio=$this->actual->fecha_inicio;
        $this->fecha_fin=$this->actual->fecha_fin;
        $this->fecha_otrosi=$this->actual->fecha_otrosi;
        $this->carta_finaliza=$this->actual->carta_finaliza;
        $this->banco=$this->actual->banco;
        $this->cuenta=$this->actual->cuenta;
        $this->arl=$this->actual->arl;
        $this->porcen_arl=$this->actual->porcen_arl;
        $this->pension=$this->actual->pension;
        $this->eps=$this->actual->eps;
        $this->caja=$this->actual->caja;
        $this->dotacion=$this->actual->dotacion;
        $this->nacimiento=$this->actual->user->perfil->fecha_nacimiento;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
                            'cargo' =>'required',
                            'tipo_contrato' =>'required',
                            'educacion' =>'required',
                            'contrato' =>'required',
                            'salario' =>'required',
                            'fecha_inicio' =>'required',
                            'banco' =>'required',
                            'cuenta' =>'required',
                            'arl' =>'required',
                            'porcen_arl' =>'required',
                            'pension' =>'required',
                            'eps' =>'required',
                            'caja' =>'required',
                            'observaciones' =>'required',
                        ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'cargo',
                        'tipo_contrato',
                        'educacion',
                        'contrato',
                        'salario',
                        'fecha_inicio',
                        'fecha_fin',
                        'fecha_otrosi',
                        'carta_finaliza',
                        'banco',
                        'cuenta',
                        'arl',
                        'porcen_arl',
                        'pension',
                        'eps',
                        'caja',
                        'dotacion',
                        'observaciones',
                    );
    }

    public function edit(){
        // validate
        $this->validate();

        $observaciones=now().": ".Auth::user()->name." registro: ".$this->observaciones." ----- ".$this->actual->observaciones;

        $this->actual->update([
            'cargo' => $this->cargo,
            'tipo_contrato' => $this->tipo_contrato,
            'educacion' => $this->educacion,
            'contrato' => $this->contrato,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'fecha_otrosi' => $this->fecha_otrosi,
            'carta_finaliza' => $this->carta_finaliza,
            'banco' => $this->banco,
            'cuenta' => $this->cuenta,
            'arl' => $this->arl,
            'porcen_arl' => $this->porcen_arl,
            'pension' => $this->pension,
            'eps' => $this->eps,
            'caja' => $this->caja,
            'dotacion' => $this->dotacion,
            'observaciones' => $observaciones,
        ]);

        //Actualizar Perfil
        Perfil::where('user_id',$this->actual->user_id)
                ->update([
                    'fecha_nacimiento'=>$this->nacimiento,
                ]);

        // Notificación
        $this->dispatch('alerta', name:'Se actualizo correctamente el registro de: '.$this->actual->user->name);
        $this->resetFields();
        $this->dispatch('cancelando');
    }

    private function regimenes(){
        return RegimenSalud::where('status', true)
                            ->orderBy('name', 'ASC')
                            ->get();
    }


    public function render()
    {
        return view('livewire.humana.configuracion.actualizar',[
            'regimenes'=>$this->regimenes(),
        ]);
    }
}
