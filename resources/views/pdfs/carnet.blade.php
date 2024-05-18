<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$matricula->alumno->name}}: {{$id}}</title>
    <link rel="shortcut icon" href="{{public_path('img/icon.ico')}}">
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}">
</head>
<body>

    <div id="head">
        <img class="imgheader" src="{{public_path('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
        <div class="infoHeader">

        </div>
    </div>

    <table class="font-sm border">
        <thead >
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    Documento de identificación:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->tipo_documento}}: {{$matricula->alumno->documento}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border ">
                    APELLIDO(s) Y NOMBRE(s):
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->name}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    FECHA Y LUGAR DE EXPEDICIÓN:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->fecha_documento}}, {{$matricula->alumno->perfil->lugar_expedicion}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    LUGAR DE ORIGEN:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->country->name}}, {{$matricula->alumno->perfil->sector->name}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    DIRECCIÓN:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->direccion}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    celular:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->celular}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    fijo:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->fijo}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    email:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->email}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    persona de contacto:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->contacto}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    teléfono contacto:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->telefono_contacto}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    fuente información sobre el instituto:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->medio}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    grupo sanguineo (rh):
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->rh_usuario}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    curso:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->curso->name}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    fecha matricula:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->created_at}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    fecha inicio clases:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->fecha_inicia}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    conocimientos del curso a realizar:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->nivel}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    talla:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->talla}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    valor pension:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    $ {{number_format($matricula->valor, 0, '.', '.')}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    aprobación de la imagen:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->autoriza_imagen}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    enfermedad:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->enfermedad}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    asistente:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->creador->name}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    genero:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->genero}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    estado civil:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->estado_civil}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    estrato:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->estrato}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    Regimen Salud:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->regimenSalud->name}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    Nivel Educativo:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->nivel_educativo}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    ocupación:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->ocupacion}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    discapacidad:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->discapacidad}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    Empresa donde trabaja:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    {{$matricula->alumno->perfil->empresa_usuario}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    matriculado(a) en:
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    ({{$matricula->sede->sector->name}}) {{$matricula->sede->name}}
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado font-sm border">
                    Por medio del presente escrito, autorizo al INSTITUTO DE
                    CAPACITACIÓN POLIANDINO CENTRAL con NIT.
                    900656857-5 a utilizar mi imagen (fotografías) para realizar
                    publicidad por medios escritos (revistas, periódicos,
                    televisión, página web, otros) o audiovisual (televisión).
                    SI:_____ NO:_____

                </th>
                <th scope="col" class="celdafirma justificado font-sm border">
                    El estudiante se compromete a acatar el Reglamento de
                    Convivencia de la Institución, cumpliendo con los costos de
                    matrícula, programa y kit de seguridad en la fecha en que se
                    programaron y entendiendo que este documento es anexo al
                    contrato que el estudiante firma para acceder al servicio
                    educativo que la institución le prestará. NO HAY
                    DEVOLUCIÓN de dinero en los costos de matrícula ni
                    programa ni kit de seguridad; a excepción de que el curso no
                    se realice.
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    <br><br><br><br>
                    fotografía del estudiante/acudiente
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    <br><br><br><br>
                    huella
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    nombre del estudiante
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">
                    firma del estudiante
                </th>
            </tr>
            <tr>
                <th scope="col" class="celdafirma justificado uppercase font-sm border">
                    <br><br>
                </th>
                <th scope="col" class="celdafirma capitalize font-sm border">

                </th>
            </tr>
        </thead>
    </table>


</body>
</html>
