<?php

namespace App\Traits;

trait FiltroTrait
{
    public $is_filtro=true;
    public $txt;
    public $is_campo=true;

    //Matricula
    public $is_Creades=false;
    public $is_Inides=false;
    public $is_matri=false;
    public $is_estatumatri=false;
    public $is_sede=false;
    public $is_sedecurso=false;
    public $is_sededir=false;

    //Curso
    public $is_curso=false;
    public $is_grupo=false;

    //Inventario
    public $is_tipo=false;
    public $is_almacen=false;
    public $is_saldo=false;

    //Usuarios
    public $is_rol=false;

    //Transacciones
    public $is_transaccion=false;

    //Casos Especiales
    public $is_verfiltro=true;

    //Cartera
    public $is_vencimiento=false;
    public $is_status_est=false;
    public $is_status_cart=false;
    public $is_etapa=false;
    public $is_grado=false;

    //Ciclos
    public $is_jornada=false;
    public $is_ciclos=false;
    public $is_ciclos_crono=false;
    public $is_profesor=false;
    public $no_soy_profe=true;

    // Recibos
    public $is_fechatransaccion=false;
    public $is_medio=false;
    public $is_cajero=false;
    public $is_conceptopag=false;

    //Documentos grado
    public $is_acta=false;
    public $is_control=false;


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
                //$this->is_estatumatri=true;
                $this->is_sede=true;
                $this->is_sedecurso=true;
                $this->is_curso=true;
                $this->is_status_est=true;
                break;

            case 2:
                $this->txt="Busque por acá: Sede, Profesor, Modulo";

                //Grupos
                $this->is_curso=true;
                $this->is_jornada=true;
                break;

            case 3:
                $this->txt="Busque por acá: Número de recibo, Fecha, medio, observaciones, cajero, pagador, concepto y sede";

                //Recibos
                $this->is_Creades=true;
                $this->is_sede=true;
                $this->is_fechatransaccion=true;
                $this->is_medio=true;
                $this->is_cajero=true;
                $this->is_conceptopag=true;
                break;

            case 4:
                $this->txt="Busque por acá: Observaciones, cajero y sede";

                //cierre caja
                $this->is_Creades=true;
                $this->is_sede=true;
                break;

            case 5:
                $this->txt="Busque por acá: Fecha movimiento, producto, almacén y usuario que registra";

                //Inventario
                $this->is_Creades=true;
                $this->is_tipo=true;
                $this->is_almacen=true;
                $this->is_saldo=true;
                break;

            case 6:
                $this->txt="Busque por acá: Nombre, correo electrónico, número documento";

                //Usuarios
                $this->is_rol=true;
                break;

            case 7:
                $this->txt="Busque por acá: fecha, observaciones, alumno, creador, gestionador, sede";

                //transacciones
                $this->is_transaccion=true;
                $this->is_Creades=true;
                break;

            case 8:
                $this->txt="Busque por acá: nombre o documento del alumno";
                $this->is_verfiltro=false;
                break;

            case 9:
                $this->txt="Busque por acá: Responsable (documento, nombre), concepto pago.";

                //Cartera
                $this->is_vencimiento=true;
                $this->is_sede=true;
                $this->is_status_est=true;
                $this->is_status_cart=true;
                break;

            case 10:
                $this->txt="Busque por acá: Nombre de la programación.";

                //Cartera
                $this->is_Inides=true;
                $this->is_sede=true;
                $this->is_curso=true;
                $this->is_jornada=true;
                break;

            case 11:
                $this->txt="Busque por acá: Nombre - documento del estudiante";
                $this->is_sededir=true;
                $this->is_Inides=true;
                $this->is_curso=true;
                $this->is_status_est=true;
                $this->is_ciclos=true;
                $this->is_profesor=true;
                $this->is_grupo=true;
                break;

            case 12:
                $this->txt="Busque por acá: Nombre y Sector";

                //Grupos
                $this->is_curso=true;
                break;

            case 13:
                $this->txt="Busque por acá: Nombre - documento del estudiante";
                $this->is_sededir=true;
                $this->is_Inides=true;
                $this->is_curso=true;
                $this->is_status_est=true;
                $this->is_grado=true;
                $this->is_ciclos=true;
                $this->is_profesor=true;
                break;

            case 14:
                $this->txt="Busque por acá: Nombre - documento del estudiante";
                $this->is_curso=true;
                $this->is_sededir=true;
                $this->is_etapa=true;
                break;

            case 15:
                $this->is_campo=false;
                $this->is_status_est=true;
                $this->is_sede=true;
                break;
            case 16:
                $this->is_campo=false;
                $this->is_acta=true;
                $this->is_control=true;
                $this->is_filtro=!$this->is_filtro;
                break;
            case 17:
                $this->is_jornada=true;
                $this->is_curso=true;
                $this->is_profesor=true;
                break;

            case 18:
                $this->txt="Busque por acá: Nombre, documento.";
                break;

            case 19:
                $this->txt="Busque por acá: Nombre del grupo.";
                $this->is_profesor=true;
                $this->is_ciclos_crono=true;
                break;
        }
    }

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
    }
}
