<?php

namespace App\Livewire\Configuracion\User;

use App\Models\Academico\Matricula;
use App\Models\Admin\RegimenSalud;
use App\Models\Configuracion\Country;
use App\Models\Configuracion\Perfil as ConfiguracionPerfil;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\State;
use App\Models\User;
use Livewire\Component;

class Perfil extends Component
{
    public $id;
    public $elegido;
    public $perf=0;
    public $actual;
    public $name = '';
    public $lastname = '';
    public $email = '';
    public $documento = '';
    public $tipo_documento = '';
    public $matriculas;


    public $regimen_salud_id;
    public $fecha_documento;
    public $lugar_expedicion;
    public $fecha_nacimiento;
    public $genero;
    public $estado_civil;

    public $country_id;
    public $sector_id;
    public $estado_id;
    public $direccion;
    public $barrio;
    public $celular;
    public $wa;
    public $fijo;
    public $contacto;
    public $documento_contacto;
    public $parentesco_contacto;
    public $telefono_contacto;


    public $talla;
    public $calzado;
    public $estrato;
    public $nivel_educativo;
    public $ocupacion;
    public $discapacidad;
    public $empresa_usuario;
    public $autoriza_imagen;
    public $carnet;
    public $arl_usuario;
    public $rh_usuario;
    public $sorteo_usuario;





    public function mount($elegido = null,$perf)
    {
        $this->id=$elegido;
        $this->actual=User::find($elegido);
        $this->perf=$perf;

        $this->valores();
    }

    public function valores(){
        $this->name=$this->actual->perfil->name;
        $this->lastname=$this->actual->perfil->lastname;
        $this->documento=$this->actual->documento;
        $this->tipo_documento=$this->actual->perfil->tipo_documento;
        $this->email=$this->actual->email;
        $this->matriculas=Matricula::where('alumno_id', $this->id)->where('status', true)->get();


        $this->fecha_documento=$this->actual->perfil->fecha_documento;
        $this->lugar_expedicion=$this->actual->perfil->lugar_expedicion;
        $this->fecha_nacimiento=$this->actual->perfil->fecha_nacimiento;
        $this->genero=$this->actual->perfil->genero;
        $this->estado_civil=$this->actual->perfil->estado_civil;
        $this->country_id=$this->actual->perfil->country_id;
        $this->sector_id=$this->actual->perfil->sector_id;
        $this->estado_id=$this->actual->perfil->estado_id;

        $this->direccion=$this->actual->perfil->direccion;
        $this->barrio=$this->actual->perfil->barrio;
        $this->estrato=$this->actual->perfil->estrato;
        $this->celular=$this->actual->perfil->celular;
        $this->wa=$this->actual->perfil->wa;
        $this->fijo=$this->actual->perfil->fijo;
        $this->contacto=$this->actual->perfil->contacto;
        $this->documento_contacto=$this->actual->perfil->documento_contacto;
        $this->parentesco_contacto=$this->actual->perfil->parentesco_contacto;
        $this->telefono_contacto=$this->actual->perfil->telefono_contacto;


        $this->regimen_salud_id=$this->actual->perfil->regimen_salud_id;
        $this->arl_usuario=$this->actual->perfil->arl_usuario;
        $this->nivel_educativo=$this->actual->perfil->nivel_educativo;
        $this->rh_usuario=$this->actual->perfil->rh_usuario;
        $this->discapacidad=$this->actual->perfil->discapacidad;
        $this->talla=$this->actual->perfil->talla;
        $this->calzado=$this->actual->perfil->calzado;


        $this->ocupacion=$this->actual->perfil->ocupacion;
        $this->empresa_usuario=$this->actual->perfil->empresa_usuario;
        $this->autoriza_imagen=$this->actual->perfil->autoriza_imagen;
        $this->carnet=$this->actual->perfil->carnet;

        $this->sorteo_usuario=$this->actual->perfil->sorteo_usuario;
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
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'lastname', 'email', 'documento', 'tipo_documento', 'password', 'id');
    }

    //Actualizar
    public function edit(){
        // validate
        $this->validate();

        //Actualizar registros
        $completo=$this->name." ".$this->lastname;
        User::whereId($this->id)->update([
            'name'=>strtolower($completo),
            'email'=>strtolower($this->email),
            'documento'=>strtolower($this->documento),
        ]);

        ConfiguracionPerfil::where('user_id',$this->id)
                ->update([
                    'tipo_documento'=>$this->tipo_documento,
                    'documento'=>$this->documento,
                    'name'=>strtolower($this->name),
                    'lastname'=>strtolower($this->lastname),

                    'fecha_documento'=>$this->fecha_documento,
                    'lugar_expedicion'=>$this->lugar_expedicion,
                    'fecha_nacimiento'=>$this->fecha_nacimiento,
                    'genero'=>$this->genero,
                    'estado_civil'=>$this->estado_civil,
                    'country_id'=>$this->country_id,
                    'sector_id'=>$this->sector_id,
                    'estado_id'=>$this->estado_id,

                    'direccion'=>$this->direccion,
                    'barrio'=>$this->barrio,
                    'estrato'=>$this->estrato,
                    'celular'=>$this->celular,
                    'wa'=>$this->wa,
                    'fijo'=>$this->fijo,
                    'contacto'=>$this->contacto,
                    'documento_contacto'=>$this->documento_contacto,
                    'parentesco_contacto'=>$this->parentesco_contacto,
                    'telefono_contacto'=>$this->telefono_contacto,

                    'regimen_salud_id'=>$this->regimen_salud_id,
                    'arl_usuario'=>$this->arl_usuario,
                    'nivel_educativo'=>$this->nivel_educativo,
                    'rh_usuario'=>$this->rh_usuario,
                    'discapacidad'=>$this->discapacidad,
                    'talla'=>$this->talla,
                    'calzado'=>$this->calzado,

                    'ocupacion'=>$this->ocupacion,
                    'empresa_usuario'=>$this->empresa_usuario,
                    'autoriza_imagen'=>$this->autoriza_imagen,
                    'carnet'=>$this->carnet,

                    'sorteo_usuario'=>$this->sorteo_usuario,
                ]);


        $this->dispatch('alerta', name:'Se ha modificado correctamente el perfil del Usuario: '.$this->actual->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Perfilando');
    }

    private function regimenes(){
        return RegimenSalud::where('status', true)
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    private function countries(){
        return Country::where('status', true)
                        ->orderBy('name','ASC')
                        ->get();
    }

    private function states(){
        return State::where('status', true)
                        ->orderBy('name','ASC')
                        ->get();
    }

    private function sectors(){
        return Sector::where('status', true)
                        ->orderBy('name','ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.user.perfil', [
            'regimenes'=>$this->regimenes(),
            'countries'=>$this->countries(),
            'states'=>$this->states(),
            'sectors'=>$this->sectors(),
        ]);
    }
}
