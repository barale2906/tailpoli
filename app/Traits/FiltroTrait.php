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

    //Curso
    public $is_curso=false;

    //Inventario
    public $is_tipo=false;


    public function filtroMostrar(){
        $this->is_filtro=!$this->is_filtro;
    }

    public function claseFiltro($id){
        switch ($id) {
            case 1:
                $this->txt="Busque por acá: Alumno (Nombre-Documento), Grupo, Curso, Sede";

                //Matricula
                $this->is_Creades=true;

                $this->is_Inides=true;

                $this->is_matri=true;

                $this->is_estatumatri=true;
                break;

            case 2:
                $this->txt="Busque por acá: Sede, Profesor, Modulo";

                //Grupos
                $this->is_curso=true;
                break;

            case 3:
                $this->txt="Busque por acá: Fecha, medio, observaciones, cajero, pagador, concepto y sede";

                //Recibos
                $this->is_Creades=true;
                break;

            case 4:
                $this->txt="Busque por acá: Fecha, observaciones, cajero y sede";

                //Recibos
                $this->is_Creades=true;
                break;

            case 5:
                $this->txt="Busque por acá: Fecha movimiento, producto, almacén y usuario que registra";

                //Recibos
                $this->is_Creades=true;
                $this->is_tipo=true;
                break;
        }
    }

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
    }
}
