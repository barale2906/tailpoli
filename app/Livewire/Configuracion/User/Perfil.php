<?php

namespace App\Livewire\Configuracion\User;

use App\Models\Academico\Matricula;
use App\Models\Admin\PersonaMulticultural;
use App\Models\Admin\RegimenSalud;
use App\Models\Configuracion\Country;
use App\Models\Configuracion\Perfil as ConfiguracionPerfil;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use App\Models\Configuracion\State;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
    public $rol;
    public $ruta;


    public $regimen_salud_id;
    public $fecha_documento;
    public $lugar_expedicion;
    public $fecha_nacimiento;
    public $genero;
    public $estado_civil;

    public $country_id;
    public $state_id=0;
    public $sector_id=0;

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

    public $disponibles=[];
    public $registro=[];

    public $sedeperte=[];
    public $noperte=[];

    public $impresion;





    public function mount($elegido = null,$perf, $impresion=null, $ruta=null)
    {
        $this->id=$elegido;
        $this->actual=User::find($elegido);
        $this->perf=$perf;
        $this->impresion=$impresion;
        $this->ruta=$ruta;

        $this->valores();
        $this->personasMulti();

    }

    public function valores(){

        $this->rol=$this->actual->roles[0]['name'];

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
        $this->state_id=$this->actual->perfil->state_id;
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

        $this->sedeActuales();
    }

    //Carga sedes a las que pertenece el usuario
    public function sedeActuales(){

        foreach ($this->actual->sedes as $value) {
            $nuevo=[
                'id'            =>$value->id,
                'name'          =>$value->name,
            ];

            if(in_array($nuevo, $this->sedeperte)){

            }else{
                array_push($this->sedeperte, $nuevo);
            }
        }

        $this->sedePendiente();
    }

    //sedes a las que no pertenece
    public function sedePendiente(){

        $sedes = Sede::where('status', true)->orderBy('name', 'ASC')->get();

        foreach ($sedes as $value) {
            $nuevo=[
                'id'            =>$value->id,
                'name'          =>$value->name,
            ];

            if(in_array($nuevo, $this->sedeperte)){

            }else{
                array_push($this->noperte, $nuevo);
            }
        }
    }

    //Elegir los modulos incluidos
    public function sel($id){

        foreach ($this->noperte as $value) {

            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name']
                ];

                if(in_array($nuevo, $this->sedeperte)){

                }else{
                    array_push($this->sedeperte, $nuevo);
                }
            };
        }
    }

    // Eliminar modulo elegido
    public function elim($id){
        foreach ($this->sedeperte as $value) {
            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name']
                ];
            }
        }
        $indice=array_search($nuevo,$this->sedeperte,true);
        unset($this->sedeperte[$indice]);
    }

    //Carga las personas multi a las que pertenece el usuario
    public function personasMulti(){

        $personas = DB::table('perfil_persona_multicultural')
                        ->where('perfil_id', $this->id)
                        ->get();

        if($personas){

            foreach($personas as $value){

                $esta=PersonaMulticultural::whereId($value->persona_multicultural_id)->first();

                if($esta->count()>0){
                    $nuevo=[
                        'id'            =>$esta->id,
                        'name'          =>$esta->name,
                    ];

                    if(in_array($nuevo, $this->disponibles)){

                    }else{
                        array_push($this->disponibles, $nuevo);
                    }
                }
            }
        }

        $this->multiCarga();
    }

    //Determina a cuales no pertenece
    public function multiCarga(){

        $multiperson=PersonaMulticultural::where('status', true)
                        ->orderBy('name','ASC')
                        ->get();
        foreach ($multiperson as $value) {
            $nuevo=[
                'id'            =>$value->id,
                'name'          =>$value->name,
            ];

            if(in_array($nuevo, $this->disponibles)){

            }else{
                array_push($this->registro, $nuevo);
            }
        }
    }

    //Elegir los modulos incluidos
    public function selGrupo($id){

        foreach ($this->registro as $value) {

            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name']
                ];

                if(in_array($nuevo, $this->disponibles)){

                }else{
                    array_push($this->disponibles, $nuevo);
                }

            };

        }
    }

    // Eliminar modulo elegido
    public function elimGrupo($id){
        foreach ($this->disponibles as $value) {
            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name']
                ];
            }
        }
        $indice=array_search($nuevo,$this->disponibles,true);
        unset($this->disponibles[$indice]);
    }

    public function pais(){
        $this->reset('state_id','sector_id');
        $this->states();
        $this->sectors();
    }

    public function depto(){
        $this->reset('sector_id');
        $this->sectors();
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
        'country_id'=>'required',
        'state_id'=>'required',
        'sector_id'=>'required',
        'fecha_nacimiento'=>'required',
        'fecha_documento'=>'required',
        'genero'=>'required',
        'estado_civil'=>'required',
        'direccion'=>'required',
        'barrio'=>'required',
        'estrato'=>'required',
        'celular'=>'required',
        'wa'=>'required',
        'contacto'=>'required',
        'telefono_contacto'=>'required',
        'regimen_salud_id'=>'required',
        'discapacidad'=>'required',
        'rh_usuario'=>'required',
        'nivel_educativo'=>'required',
        'ocupacion'=>'required',
        'empresa_usuario'=>'required',
        'carnet'=>'required',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'password',
                        'name',
                        'lastname',
                        'email',
                        'documento',
                        'tipo_documento',
                        'country_id',
                        'state_id',
                        'sector_id',
                        'fecha_nacimiento',
                        'fecha_documento',
                        'genero',
                        'estado_civil',
                        'direccion',
                        'barrio',
                        'estrato',
                        'celular',
                        'wa',
                        'contacto',
                        'telefono_contacto',
                        'regimen_salud_id',
                        'discapacidad',
                        'rh_usuario',
                        'nivel_educativo',
                        'ocupacion',
                        'empresa_usuario',
                        'carnet',
                        'id'
                    );
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

        $perfilActual=ConfiguracionPerfil::where('user_id',$this->id)->first();


        $perfilActual->update([
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
                    'state_id'=>$this->state_id,
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

        $ids=[];

        $perfilActual->personamulticulturals()->sync($ids);


        // Asignar multicultural
        foreach ($this->disponibles as $value) {
            DB::table('perfil_persona_multicultural')
            ->insert([
                'perfil_id'                 =>$this->id,
                'persona_multicultural_id'  =>$value['id'],
                'created_at'                =>now(),
                'updated_at'                =>now(),
            ]);
        }

        //Actualizar sedes
        $this->actual->sedes()->sync($ids);

        // Asignar multicultural
        foreach ($this->sedeperte as $value) {
            DB::table('sede_user')
            ->insert([
                'user_id'                   =>$this->id,
                'sede_id'                   =>$value['id'],
                'created_at'                =>now(),
                'updated_at'                =>now(),
            ]);
        }

        $this->dispatch('alerta', name:'Se ha modificado correctamente el perfil del Usuario: '.$this->actual->name);

        if($this->perf===1){
            $this->dispatch('visual');
        }else{
            if($this->perf===0){

                $this->resetFields();
            }


            //refresh
            $this->dispatch('refresh');
            $this->dispatch('Perfilando');
        }


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
                        ->where('country_id', $this->country_id)
                        ->orderBy('name','ASC')
                        ->get();
    }

    private function sectors(){
        return Sector::where('status', true)
                        ->where('state_id', $this->state_id)
                        ->orderBy('name','ASC')
                        ->get();
    }



    public function render()
    {
        return view('livewire.configuracion.user.perfil', [
            'regimenes'=>$this->regimenes(),
            'countries'=>$this->countries(),
            'states'=>$this->states(),
            'sectors'=>$this->sectors()
        ]);
    }
}
