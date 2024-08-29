<?php

namespace App\Livewire\Financiera\Cartera;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Cuotaplazamiento extends Component
{
    use WithPagination;

    public $valor;

    public $ordena='status';
    public $ordenado='ASC';
    public $pages = 15;

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

    //Numero de registros
    public function paginas($valor)
    {
        $this->resetPage();
        $this->pages=$valor;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'valor' => 'required|integer',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('valor');
    }


    public function crea(){

        // validate
        $this->validate();

        // anular la anterior
        $ant= DB::table('cuotaplaza')
                ->where('status',1)
                ->first();

        $act=now()." ". Auth::user()->name." ----- ".$ant->cambio;

        DB::table('cuotaplaza')
            ->where('id',$ant->id)
            ->update([
                'status'=>2,
                'cambio'=>$act,
            ]);


        DB::table('cuotaplaza')
            ->insert([
                'valor'         =>$this->valor,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado y puesto en vigencia la nueva cuota de aplazamiento.');
        $this->resetFields();
    }

    private function cuotas(){
        return DB::table('cuotaplaza')
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.financiera.cartera.cuotaplazamiento',[
            'cuotas'    =>$this->cuotas(),
        ]);
    }
}
