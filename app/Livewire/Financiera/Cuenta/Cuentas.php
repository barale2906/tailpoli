<?php

namespace App\Livewire\Financiera\Cuenta;

use App\Models\Financiera\Cuenta;
use Livewire\Attributes\On;
use Livewire\Component;

class Cuentas extends Component
{
    public $ordena='tipo';
    public $ordenado='ASC';
    public $elegido;
    public $accion;

    public $is_modify = true;
    public $is_creating = false;

    // Ordenar Registros
    public function organizar($campo)
    {
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating'
                    );
    }


    // Mostrar Regimen de Salud
    public function show($act, $esta=null ){
        if($esta){
            $this->elegido=$esta;
        }
        $this->is_creating = !$this->is_creating;
        $this->is_modify=!$this->is_modify;
        $this->accion=$act;
    }

    private function centros(){
        return Cuenta::orderBy('tipo', 'ASC')
                        ->orderBy($this->ordena, $this->ordenado)
                        ->get();
    }

    public function render()
    {
        return view('livewire.financiera.cuenta.cuentas',[
            'centros'   => $this->centros(),
        ]);
    }
}
