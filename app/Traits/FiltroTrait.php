<?php

namespace App\Traits;

trait FiltroTrait
{
    public $is_filtro=false;
    public $txt;

    //Matricula
    public $is_Creades=false;

    public $is_Inides=false;

    public $is_matri=false;

    public $is_estatumatri=false;

    public function filtroMostrar(){
        $this->is_filtro=!$this->is_filtro;
    }

    public function claseFiltro($id){
        switch ($id) {
            case 1:
                $this->txt="Busque por acá: Alumno, Grupo, Curso, Sede";

                //Matricula
                $this->is_Creades=true;

                $this->is_Inides=true;

                $this->is_matri=true;

                $this->is_estatumatri=true;
                break;

            default:
                # code...
                break;
        }
    }

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
    }
}
