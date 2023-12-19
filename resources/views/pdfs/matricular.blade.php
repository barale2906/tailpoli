<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documentos Matricula</title>
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}">


</head>
<body>

    <div id="head">
        <img class="imgheader" src="{{public_path('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
        <div class="infoHeader">

        </div>
    </div>
    @foreach ($matr as $mat)
        @if ($mat->tipo==='matricula')
            <h1 class="centrado uppercase">
                Hoja de matricula n°: {{$id}}
            </h1>
            <table class="font-sm border">
                <thead >
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            Documento de identificación:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border ">
                            APELLIDO(s) Y NOMBRE(s):
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->name}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            FECHA Y LUGAR DE EXPEDICIÓN:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->fecha_documento}}, {{$docuMatricula->alumno->perfil->lugar_expedicion}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            LUGAR DE ORIGEN:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->country->name}}, {{$docuMatricula->alumno->perfil->sector->name}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            DIRECCIÓN:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->direccion}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            celular:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->celular}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            fijo:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->fijo}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            email:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->email}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            persona de contacto:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->contacto}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            teléfono contacto:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->telefono_contacto}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            fuente información sobre el instituto:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->medio}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            grupo sanguineo (rh):
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->rh_usuario}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            curso:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->curso->name}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            fecha matricula:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->created_at}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            fecha inicio clases:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->fecha_inicia}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            conocimientos del curso a realizar:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->nivel}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            talla:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->talla}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            valor pension:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            $ {{number_format($docuMatricula->valor, 0, '.', '.')}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            aprobación de la imagen:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->autoriza_imagen}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            enfermedad:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->enfermedad}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            asistente:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->creador->name}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            genero:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->genero}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            estado civil:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->estado_civil}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            estrato:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->estrato}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            Regimen Salud:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->regimenSalud->name}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            Nivel Educativo:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->nivel_educativo}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            ocupación:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->ocupacion}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            discapacidad:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->discapacidad}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            Empresa donde trabaja:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            {{$docuMatricula->alumno->perfil->empresa_usuario}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="celdafirma justificado uppercase font-sm border">
                            matriculado(a) en:
                        </th>
                        <th scope="col" class="celdafirma capitalize font-sm border">
                            ({{$docuMatricula->sede->sector->name}}) {{$docuMatricula->sede->name}}
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
            <div class="salto"></div>

        @endif
        @foreach ($detalles as $item)
            @if ($item['documento_id']===$mat->id && $item['tipo']==='titulo')
                <h1 class="centrado uppercase">
                    {{$item['contenido']}}
                </h1>
            @endif
        @endforeach
        @switch($mat->tipo)
            @case('contrato')
                <div class="content">
                    <p class="justificado">
                        NOMBRE DEL CURSO: <strong>{{$docuMatricula->curso->name}}</strong>
                    </p>
                    <p class="justificado">
                        Duración del curso: <strong>{{-- {{$docuMatricula->curso->duracion_horas}} horas /  --}}{{$docuMatricula->curso->duracion_meses}} meses</strong>
                    </p>
                    <p class="justificado">
                        Lugar:
                        <strong class="capitalize">
                            {{$docuMatricula->sede->name}} - {{$docuMatricula->sede->sector->name}}
                            - {{$docuMatricula->sede->sector->state->name}}
                        </strong>
                    </p>
                    <p class="justificado">
                        Valor:
                        <strong>
                            $ {{number_format($docuMatricula->valor, 0, '.', '.')}}
                        </strong>
                    </p>
                    <p class="justificado">
                        Pagaré Autorizado N°: {{$docuMatricula->id}}
                    </p>
                </div>
                @break
            @case('pagare')
                <p class="font-sm justificado uppercase">
                    LUGAR Y FECHA: ___________________________________
                </p>
                <p class="font-sm justificado uppercase">
                    VALOR: $ _________________________________________
                </p>
                <p class="font-sm justificado uppercase">
                    INTERESES DE MORA: __ %
                </p>
                <p class="font-sm justificado uppercase">
                    PERSONA A QUIEN DEBE HACERSE EL PAGO: {{config('instituto.nombre_empresa')}}
                </p>
                <p class="font-sm justificado uppercase">
                    LUGAR DONDE SE EFECTUARÁ EL PAGO: {{config('instituto.direccion')}}
                </p>
                <p class="font-sm izquierda uppercase">
                    FECHA DE VENCIMIENTO DE LA OBLIGACIÓN: __________________________________
                </p>
                <p class="font-sm justificado capitalize m-5">
                    DEUDORES:
                </p>
                <p class="font-sm justificado capitalize">
                    Nombre: ________________________________________________________________________________
                </p>
                <p class="font-sm justificado capitalize">
                    Identificación: ________________________________________________________________________
                </p>
                <p class="font-sm justificado capitalize">
                    Nombre: ________________________________________________________________________________
                </p>
                <p class="font-sm justificado capitalize">
                    Identificación: ________________________________________________________________________
                </p>
                <p class="font-sm justificado capitalize m-3">
                    DECLARAMOS:
                </p>
                @break
            @default

        @endswitch
        @foreach ($detalles as $item)
            @if ($item['documento_id']===$mat->id )
                @switch($item['tipo'])
                    @case('parrafo')
                        <p class="justificado font-sm">
                            {{$item['contenido']}}
                        </p>
                        @break

                    @case('formaPago')
                        @if ($docuFormaP->cuotas>0)
                            <table>
                                <thead class="font-sm  uppercase ">
                                    <tr>
                                        <th scope="col" class="centrado font-sm">
                                            concepto
                                        </th>
                                        <th scope="col" class="centrado font-sm">
                                            fecha de pago
                                        </th>
                                        <th scope="col" class="centrado font-sm">
                                            valor
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($docuCartera as $item)
                                        <tr>
                                            <th scope="row" class="justificado capitalize font-sm">
                                                {{$item->concepto}}
                                            </th>
                                            <th scope="row" class=" centrado capitalize font-sm">
                                                {{$item->fecha_pago}}
                                            </th>
                                            <th scope="row" class="derecha capitalize font-sm">
                                                $ {{number_format($item->valor, 0, '.', '.')}}
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="font-l centrado">
                                ¡Pago de Contado!, Según lo especificado al momento de la matricula.
                            </p>
                        @endif
                        @break
                @endswitch
            @endif
        @endforeach

        @foreach ($detalles as $item)
            @if ($item['documento_id']===$mat->id && $item['tipo']==='firma')
                @switch($mat->tipo)
                    @case('contrato')
                        <table class="font-sm mt-2">
                            <thead >
                                <tr>
                                    <th scope="col" class="celdafirma">
                                        ____________________________________
                                    </th>
                                    <th scope="col" class="celdafirma">
                                        ____________________________________
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col" class="celdafirma centrado uppercase">
                                        {{$docuMatricula->alumno->name}}<br>
                                        {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}
                                    </th>
                                    <th scope="col" class="celdafirma uppercase centrado font-sm p-1">
                                        {{config('instituto.nombre_empresa')}}<br>
                                        NIT: {{config('instituto.nit')}}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="salto"></div>
                        @break
                    @case('pagare')
                        <p class="font-sm justificado">
                            En constancia de lo anterior, se suscribe este documento el día: <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>
                        </p>
                        <p class="justificado font-sm capitalize mt-1">
                            Firma: _______________________________________________________________________________
                        </p>
                        <p class="justificado font-sm capitalize mt-1">
                            Nombre: ______________________________________________________________________________
                        </p>
                        <p class="justificado font-sm capitalize mt-1">
                            Cédula: ______________________________________________________________________________
                        </p>
                        <p class="justificado font-sm capitalize mt-1">
                            Dirección: ___________________________________________________________________________
                        </p>
                        <div class="salto"></div>
                        @break
                    @case('cartaPagare')
                        <p class="justificado font-sm">
                            Para constancia se firma en: ____________________,  a los: <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>, el obligado principal:
                        </p>

                        <table >
                            <thead >
                                <tr>
                                    <th scope="col" >
                                        <p class="justificado font-sm capitalize mt-1">
                                            Firma: _________________________________________________
                                        </p>
                                        <p class="justificado font-sm capitalize">
                                            Nombre: _________________________________________________
                                        </p>
                                        <p class="justificado font-sm capitalize">
                                            Cédula: _________________________________________________
                                        </p>
                                    </th>
                                    <th scope="col" >

                                        <p class="justificado font-l bg-gris capitalize mt-1 border">
                                            <br><br><br>
                                            Huella
                                        </p>

                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="salto"></div>
                        @break
                    @case('actaPago')
                        <table class="font-sm mt-2">
                            <thead >
                                <tr>
                                    <th scope="col" class="celdafirma">
                                        ____________________________________
                                    </th>
                                    <th scope="col" class="celdafirma">

                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col" class="celdafirma centrado uppercase">
                                        {{$docuMatricula->alumno->name}}<br>
                                        {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}
                                    </th>
                                    <th scope="col" class="celdafirma uppercase centrado font-sm p-1">

                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="salto"></div>
                        @break

                    @case('comproCredito')
                        <p class="justificado font-sm">
                            En Constancia de lo anterior, y declarando que estoy en acuerdo con todas las clausulas aquí establecidas, siendo así, se suscribe este documento en la ciudad de: ____________________ el día <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>.
                        </p>

                        <table >
                            <thead >
                                <tr>
                                    <th scope="col" >
                                        <p class="justificado font-sm capitalize mt-1">
                                            Firma: _________________________________________________
                                        </p>
                                        <p class="justificado font-sm capitalize">
                                            {{$docuMatricula->alumno->name}}<br>
                                            {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}<br>
                                            Célular: {{$docuMatricula->alumno->perfil->celular}}<br>
                                            Dirección: {{$docuMatricula->alumno->perfil->direccion}}
                                        </p>
                                    </th>
                                    <th scope="col" >

                                        <p class="justificado font-l bg-gris capitalize mt-1 border">
                                            <br><br><br>
                                            Huella
                                        </p>

                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="salto"></div>
                        @break

                    @case('comproEntrega')
                        <p class="justificado font-sm">
                            Se firma el: {{$fechaMes}}
                        </p>

                        <table >
                            <thead >
                                <tr>
                                    <th scope="col" >
                                        <p class="justificado font-sm uppercase mt-1">
                                            Aceptado:
                                        </p>
                                        <p class="justificado font-sm capitalize mt-1">
                                            Firma: _________________________________________________
                                        </p>
                                        <p class="justificado font-sm capitalize">
                                            {{$docuMatricula->alumno->name}}<br>
                                            {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}<br>
                                            Célular: {{$docuMatricula->alumno->perfil->celular}}<br>
                                            Correo Electrónico: {{$docuMatricula->alumno->email}}
                                        </p>
                                    </th>
                                    <th scope="col" >

                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="salto"></div>
                        @break

                    @case('gastocertifinal')

                        <table >
                            <thead >
                                <tr>
                                    <th scope="col" >
                                        <p class="justificado font-sm uppercase mt-1">
                                            Aceptado:
                                        </p>
                                        <p class="justificado font-sm capitalize mt-1">
                                            Firma: _________________________________________________
                                        </p>
                                        <p class="justificado font-sm capitalize">
                                            {{$docuMatricula->alumno->name}}<br>
                                            {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}<br>
                                            Célular: {{$docuMatricula->alumno->perfil->celular}}<br>
                                            Correo Electrónico: {{$docuMatricula->alumno->email}}
                                        </p>
                                    </th>
                                    <th scope="col" >

                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="salto"></div>
                        @break

                    @case('certiEstudio')

                        <p class="justificado font-sm">
                            La presente certificación se expide a petición del interesado el: <strong>{{$fechaMes}}</strong>
                        </p>

                        <table >
                            <thead >
                                <tr>
                                    <th scope="col" >
                                        <p class="justificado font-sm uppercase mt-1">
                                            Cordialmente:
                                        </p>
                                        <p class="justificado font-sm capitalize mt-1">
                                            Firma: _________________________________________________
                                        </p>
                                        <img class="rounded-sm" src="{{asset('img/firma_directora.png')}}" alt="{{config('instituto.directora')}}">
                                        <p class="justificado font-sm uppercase">
                                            director(a)
                                        </p>
                                    </th>
                                    <th scope="col" >

                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="salto"></div>
                        @break

                    @default
                    <div class="salto"></div>
                @endswitch
            @endif
        @endforeach



    @endforeach


</body>
</html>

