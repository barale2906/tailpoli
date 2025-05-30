<?php

namespace App\Livewire\Configuracion\User;

use App\Models\Configuracion\Perfil;
use App\Models\Humana\Funcionario;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersCreate extends Component
{
    public $name = '';
    public $lastname = '';
    public $email = '';
    public $documento = '';
    public $tipo_documento = '';
    public $password = '';
    public $rol = '';
    public $rol_id=6;
    public $clase;
    public $perf;
    public $nuevoUs;
    public $vista=true;
    public $ruta;

    public $elegido;



    public function mount($clase=null, $perf=null, $ruta=null){
        $this->clase=$clase;
        $this->perf=$perf;
        $this->ruta=$ruta;

        $this->tipo();
    }

    public function tipo(){
        if($this->clase===1){
            $this->rol="Estudiante";
            $this->password="10203040";
        }
        if($this->clase===2){
            $this->rol="Profesor";
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'lastname' => 'required|max:100',
        'email'=>'required|email',
        'documento'=>'required',
        'tipo_documento'=>'required',
        'password'=>'required|min:8',
        'rol'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'lastname', 'email', 'documento', 'tipo_documento', 'password','rol');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=User::Where('email','=',strtolower($this->email))
                    ->orWhere('documento','=',strtolower($this->documento))
                    ->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este Usuario: '.$this->name);
        } else {



            //Crear registro
            $completo=$this->name." ".$this->lastname;

            if($this->perf===0){
                $this->password=$this->documento;
            }

            if($this->rol==="Estudiante"){
                $this->password=$this->documento;
            }

            //id del rol
            $rolelegido=Role::where('name', $this->rol)
                                ->first();

            $this->nuevoUs=User::create([
                'rol_id'=>$rolelegido->id,
                'name'=>strtolower($completo),
                'email'=>strtolower($this->email),
                'documento'=>strtolower($this->documento),
                'password'=>bcrypt($this->password),
            ]);

            $this->nuevoUs->assignRole($this->rol);

            Perfil::create([
                'user_id'=>$this->nuevoUs->id,
                'country_id'=>1,
                'sector_id'=>1,
                'state_id'=>1,
                'estado_id'=>1,
                'regimen_salud_id'=>1,
                'tipo_documento'=>$this->tipo_documento,
                'documento'=>$this->documento,
                'name'=>strtolower($this->name),
                'lastname'=>strtolower($this->lastname)
            ]);

            // Crear funcionario
            if($rolelegido->id<6){
                Funcionario::create([
                            'user_id'=>$this->nuevoUs->id,
                            'cargo'=>$rolelegido->name,
                            'tipo_contrato'=>1,
                            'educacion'=>'básico',
                            'contrato'=>now(),
                            'salario'=>0,
                            'fecha_inicio'=>now(),
                            'banco'=>'Banco',
                            'cuenta'=>'pendiente',
                            'arl'=>'Sura',
                            'porcen_arl'=>0.522,
                            'pension'=>'pendiente',
                            'eps'=>'pendiente',
                            'caja'=>'pendiente',
                            'conyuge'=>' ',
                            'observaciones'=>now().' '.Auth::user()->name.': Creo el funcionario en el sistema.',
                ]);
            }


            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el Usuario: '.$this->name.', por favor complete su perfil.');
            $this->resetFields();

            if($this->perf===0){
                $this->vista=!$this->vista;
                $this->elegido=$this->nuevoUs->id;
            }else{
                //refresh
                $this->dispatch('refresh');
                $this->dispatch('created');
            }

        }
    }

    //Activar evento
    #[On('visual')]
    //Mostrar formulario de creación
    public function updatedVista()
    {
        $this->vista = true;
        $this->dispatch('created');
    }

    private function roles(){
        return Role::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.user.users-create', [
            'roles'=>$this->roles(),
        ]);
    }
}
