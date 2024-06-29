<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$docuMatricula->alumno->name}}: {{$id}}</title>
    <link rel="shortcut icon" href="{{public_path('img/icon.ico')}}">
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}">
</head>
<body>
    @switch($plantilla)
        @case(1)

            <div id="head">
                <img class="imgheader" src="{{public_path('img/encabezado.png')}}" alt="{{env('APP_NAME')}}">
            </div>

            <div class="marcagua">
                <img src="{{ public_path('img/logo.jpeg') }}" alt="marcagua" width="400">
            </div>

            <div class="table-wrapper">
                <div class="table-cel">
                    <div class="content">
                        @if ($matricula===1)
                            @foreach ($detalles as $item)

                                @switch($item['tipo'])
                                    @case('titulo')
                                        <h1 class="centrado uppercase mt-15">
                                            {{$item['contenido']}}
                                        </h1>
                                        @break

                                    @case('ciudadfecha')
                                        <p class="justificado font-sm">
                                            Bogotá,
                                            <strong class="uppercase">
                                                {{$fechaMes}}
                                            </strong>
                                        </p>
                                        @break

                                    @case('destinatario')
                                        <p class="justificado font-sm">
                                            Señor(a):<br>
                                            <strong class="uppercase">
                                                {{$docuMatricula->alumno->name}}<br>
                                                {{$docuMatricula->alumno->perfil->tipo_documento}}: {{number_format($docuMatricula->alumno->documento, 0, '.', '.')}}
                                            </strong>
                                        </p>
                                        @break

                                    @case('parrafo')
                                        <p class="justificado font-sm">
                                            {{$item['contenido']}}
                                        </p>
                                        @break

                                    @case('parrafo1')
                                        <div class="content">
                                            <p class="justificado font-sm">
                                                {{$item['contenido']}}
                                            </p>
                                        </div>
                                        @break

                                    @case('modulos')
                                        <div class="content">
                                            <h1>
                                                El curso: <span class=" uppercase">{{$docuMatricula->curso->name}}</span> esta compuesto por los siguientes modulos:
                                            </h1>
                                            @foreach ($modulos as $item)
                                                <p class="justificado font-sm capitalize">
                                                    {{$item->name}}
                                                </p>
                                            @endforeach
                                        </div>
                                        @break

                                    @case('linea')
                                        <p class="justificado font-sm">
                                            Para constancia se firma en: ____________________,  a los: <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>, el obligado principal:
                                        </p>
                                        @break

                                    @case('linea1')
                                        <p class="justificado font-sm">
                                            En Constancia de lo anterior, y declarando que estoy en acuerdo con todas las clausulas aquí establecidas, siendo así, se suscribe este documento en la ciudad de: ____________________ el día <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>.
                                        </p>
                                        @break

                                    @case('firma1')
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
                                                        @if ($edad>=18)
                                                            <p class="justificado font-sm capitalize">
                                                                {{$docuMatricula->alumno->name}}<br>
                                                                {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}<br>
                                                                Célular: {{$docuMatricula->alumno->perfil->celular}}<br>
                                                                Correo Electrónico: {{$docuMatricula->alumno->email}}
                                                            </p>
                                                        @else
                                                            <p class="justificado font-sm capitalize">
                                                                ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                                CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                                Célular: {{$docuMatricula->alumno->perfil->celular}} - Acudiente: {{$docuMatricula->alumno->perfil->telefono_contacto}}<br>
                                                                Correo Electrónico: {{$docuMatricula->alumno->email}} - Acudiente: {{$docuMatricula->alumno->perfil->email_contacto}}
                                                            </p>
                                                        @endif

                                                    </th>
                                                    <th scope="col" >

                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        @break

                                    @case('firma2')
                                        <table class="font-sm mt-2">
                                            <thead >
                                                <tr>
                                                    <th scope="col" class="celdafirma">
                                                        ____________________________________
                                                    </th>
                                                    <th scope="col" class="celdafirma">

                                                    </th>
                                                </tr>
                                                @if ($edad>=18)
                                                    <tr>
                                                        <th scope="col" class="celdafirma centrado uppercase">
                                                            {{$docuMatricula->alumno->name}}<br>
                                                            {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}
                                                        </th>
                                                        <th scope="col" class="celdafirma uppercase centrado font-sm p-1">

                                                        </th>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th scope="col" class="celdafirma centrado uppercase">
                                                            ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                            CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                        </th>
                                                        <th scope="col" class="celdafirma uppercase centrado font-sm p-1">

                                                        </th>
                                                    </tr>
                                                @endif
                                            </thead>
                                        </table>
                                        @break

                                    @case('firma3')
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
                                        @break

                                    @case('firma4')
                                        <table >
                                            <thead >
                                                <tr>
                                                    @if ($edad>=18)
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
                                                    @else
                                                        <th scope="col" >
                                                            <p class="justificado font-sm capitalize mt-1">
                                                                Firma: _________________________________________________
                                                            </p>
                                                            <p class="justificado font-sm capitalize">
                                                                ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                                CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                                Célular: {{$docuMatricula->alumno->perfil->celular}} - Acudiente: {{$docuMatricula->alumno->perfil->telefono_contacto}}<br>
                                                                Dirección: {{$docuMatricula->alumno->perfil->direccion}}
                                                            </p>
                                                        </th>
                                                    @endif

                                                    <th scope="col" >

                                                        <p class="justificado font-l bg-gris capitalize mt-1 border">
                                                            <br><br><br>
                                                            Huella
                                                        </p>

                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        @break

                                    @case('firma5')
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
                                        @break

                                    @case('firma6')
                                        <table >
                                            <thead >
                                                <tr>
                                                    <th scope="col" >
                                                        <p class="justificado font-sm uppercase mt-1">
                                                            Cordialmente:
                                                        </p>

                                                        <p class="justificado font-sm capitalize mt-1">
                                                            Departamento de Cartera
                                                        </p>
                                                    </th>
                                                    <th scope="col" >

                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        @break

                                    @case('firma7')
                                        <table >
                                            <thead >
                                                <tr>
                                                    <th scope="col" >
                                                        <p class="justificado font-sm uppercase mt-1">
                                                            Cordialmente:
                                                        </p>

                                                        <p class="justificado font-sm capitalize mt-1">
                                                            Firma:
                                                        </p>
                                                        <div class="justificado">
                                                            <img class="imgfirma" src="{{public_path('img/firma_directora.png')}}" alt="{{config('instituto.directora')}}">
                                                        </div>

                                                        <p class="justificado font-sm uppercase">
                                                            director(a)
                                                        </p>
                                                    </th>
                                                    <th scope="col" >

                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        @break


                                    @case('firma8')
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
                                                @if ($edad>=18)
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
                                                @else
                                                    <tr>
                                                        <th scope="col" class="celdafirma centrado uppercase">
                                                            ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                            CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                        </th>
                                                        <th scope="col" class="celdafirma uppercase centrado font-sm p-1">
                                                            {{config('instituto.nombre_empresa')}}<br>
                                                            NIT: {{config('instituto.nit')}}
                                                        </th>
                                                    </tr>
                                                @endif

                                            </thead>
                                        </table>
                                        @break

                                    @case('formaPago')
                                        @if ($docuFormaP)
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
                                            @endif

                                        @else
                                            <p class="font-l centrado">
                                                ¡Pago de Contado!, Según lo especificado al momento de la matricula.
                                            </p>
                                        @endif
                                        @break

                                    @case('cartera')
                                        @if ($docuCartera)
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
                                                        <th scope="col" class="centrado font-sm">
                                                            Días de retraso
                                                        </th>
                                                        <th scope="col" class="centrado font-sm">
                                                            Saldo
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
                                                            <th scope="row" class="derecha capitalize font-sm">
                                                                @if ($item->fecha_pago < $fecha)
                                                                    @php
                                                                        $fecha1 = date_create($item->fecha_pago);
                                                                        $dias = date_diff($fecha1, $fecha)->format('%R%a');
                                                                    @endphp
                                                                    {{$dias}} días
                                                                @endif
                                                            </th>
                                                            <th scope="row" class="derecha capitalize font-sm">
                                                                $ {{number_format($item->saldo, 0, '.', '.')}}
                                                            </th>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                        @break

                                    @case('matricula')
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
                                        @break

                                    @default
                                        <div class="salto"></div>
                                @endswitch

                            @endforeach

                        @endif

                        @if ($matricula===2)
                            @foreach ($matr as $value)
                                @foreach ($detalles as $item)
                                    @if ($item['documento_id']===$value->id)
                                        @switch($item['tipo'])
                                            @case('titulo')
                                                <h1 class="centrado uppercase">
                                                    {{$item['contenido']}}
                                                </h1>
                                                @break

                                            @case('ciudadfecha')
                                                <p class="justificado font-sm">
                                                    Bogotá,
                                                    <strong class="uppercase">
                                                        {{$fechaMes}}
                                                    </strong>
                                                </p>
                                                @break

                                            @case('destinatario')
                                                <p class="justificado font-sm">
                                                    Señor(a):<br>
                                                    <strong class="uppercase">
                                                        {{$docuMatricula->alumno->name}}<br>
                                                        {{$docuMatricula->alumno->perfil->tipo_documento}}: {{number_format($docuMatricula->alumno->documento, 0, '.', '.')}}
                                                    </strong>
                                                </p>
                                                @break

                                            @case('parrafo')
                                                <p class="justificado font-sm">
                                                    {{$item['contenido']}}
                                                </p>
                                                @break

                                            @case('parrafo1')
                                                <div class="content">
                                                    <p class="justificado font-sm">
                                                        {{$item['contenido']}}
                                                    </p>
                                                </div>
                                                @break

                                            @case('modulos')
                                                <div class="content">
                                                    <h1>
                                                        El curso: <span class=" uppercase">{{$docuMatricula->curso->name}}</span> esta compuesto por los siguientes modulos:
                                                    </h1>
                                                    @foreach ($docuMatricula->curso->modulos as $item)
                                                        <p class="justificado font-sm capitalize">
                                                            {{$item->name}}
                                                        </p>
                                                    @endforeach
                                                </div>
                                                @break

                                            @case('linea')
                                                <p class="justificado font-sm">
                                                    Para constancia se firma en: ____________________,  a los: <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>, el obligado principal:
                                                </p>
                                                @break

                                            @case('linea1')
                                                <p class="justificado font-sm">
                                                    En Constancia de lo anterior, y declarando que estoy en acuerdo con todas las clausulas aquí establecidas, siendo así, se suscribe este documento en la ciudad de: ____________________ el día <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>.
                                                </p>
                                                @break

                                            @case('firma1')
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
                                                                @if ($edad>=18)
                                                                    <p class="justificado font-sm capitalize">
                                                                        {{$docuMatricula->alumno->name}}<br>
                                                                        {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}<br>
                                                                        Célular: {{$docuMatricula->alumno->perfil->celular}}<br>
                                                                        Correo Electrónico: {{$docuMatricula->alumno->email}}
                                                                    </p>
                                                                @else
                                                                    <p class="justificado font-sm capitalize">
                                                                        ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                                        CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                                        Célular: {{$docuMatricula->alumno->perfil->celular}} - Acudiente: {{$docuMatricula->alumno->perfil->telefono_contacto}}<br>
                                                                        Correo Electrónico: {{$docuMatricula->alumno->email}} - Acudiente: {{$docuMatricula->alumno->perfil->email_contacto}}
                                                                    </p>
                                                                @endif

                                                            </th>
                                                            <th scope="col" >

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                @break

                                            @case('firma2')
                                                <table class="font-sm mt-2">
                                                    <thead >
                                                        <tr>
                                                            <th scope="col" class="celdafirma">
                                                                ____________________________________
                                                            </th>
                                                            <th scope="col" class="celdafirma">

                                                            </th>
                                                        </tr>
                                                        @if ($edad>=18)
                                                            <tr>
                                                                <th scope="col" class="celdafirma centrado uppercase">
                                                                    {{$docuMatricula->alumno->name}}<br>
                                                                    {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}
                                                                </th>
                                                                <th scope="col" class="celdafirma uppercase centrado font-sm p-1">

                                                                </th>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <th scope="col" class="celdafirma centrado uppercase">
                                                                    ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                                    CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                                </th>
                                                                <th scope="col" class="celdafirma uppercase centrado font-sm p-1">

                                                                </th>
                                                            </tr>
                                                        @endif
                                                    </thead>
                                                </table>
                                                @break

                                            @case('firma3')
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
                                                @break

                                            @case('firma4')
                                                <table >
                                                    <thead >
                                                        <tr>
                                                            @if ($edad>=18)
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
                                                            @else
                                                                <th scope="col" >
                                                                    <p class="justificado font-sm capitalize mt-1">
                                                                        Firma: _________________________________________________
                                                                    </p>
                                                                    <p class="justificado font-sm capitalize">
                                                                        ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                                        CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                                        Célular: {{$docuMatricula->alumno->perfil->celular}} - Acudiente: {{$docuMatricula->alumno->perfil->telefono_contacto}}<br>
                                                                        Dirección: {{$docuMatricula->alumno->perfil->direccion}}
                                                                    </p>
                                                                </th>
                                                            @endif

                                                            <th scope="col" >

                                                                <p class="justificado font-l bg-gris capitalize mt-1 border">
                                                                    <br><br><br>
                                                                    Huella
                                                                </p>

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                @break

                                            @case('firma5')
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
                                                @break

                                            @case('firma6')
                                                <table >
                                                    <thead >
                                                        <tr>
                                                            <th scope="col" >
                                                                <p class="justificado font-sm uppercase mt-1">
                                                                    Cordialmente:
                                                                </p>

                                                                <p class="justificado font-sm capitalize mt-1">
                                                                    Departamento de Cartera
                                                                </p>
                                                            </th>
                                                            <th scope="col" >

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                @break

                                            @case('firma7')
                                                <table >
                                                    <thead >
                                                        <tr>
                                                            <th scope="col" >
                                                                <p class="justificado font-sm uppercase mt-1">
                                                                    Cordialmente:
                                                                </p>

                                                                <p class="justificado font-sm capitalize mt-1">
                                                                    Firma:
                                                                </p>
                                                                <div class="justificado">
                                                                    <img class="imgfirma" src="{{public_path('img/firma_directora.png')}}" alt="{{config('instituto.directora')}}">
                                                                </div>

                                                                <p class="justificado font-sm uppercase">
                                                                    director(a)
                                                                </p>
                                                            </th>
                                                            <th scope="col" >

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                @break


                                            @case('firma8')
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
                                                        @if ($edad>=18)
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
                                                        @else
                                                            <tr>
                                                                <th scope="col" class="celdafirma centrado uppercase">
                                                                    ACUDIENTE: {{$docuMatricula->alumno->perfil->contacto}}<br>
                                                                    CÉDULA: {{$docuMatricula->alumno->perfil->documento_contacto}}
                                                                </th>
                                                                <th scope="col" class="celdafirma uppercase centrado font-sm p-1">
                                                                    {{config('instituto.nombre_empresa')}}<br>
                                                                    NIT: {{config('instituto.nit')}}
                                                                </th>
                                                            </tr>
                                                        @endif

                                                    </thead>
                                                </table>
                                                @break

                                            @case('formaPago')
                                                @if ($docuFormaP)
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
                                                    @endif

                                                @else
                                                    <p class="font-l centrado">
                                                        ¡Pago de Contado!, Según lo especificado al momento de la matricula.
                                                    </p>
                                                @endif
                                                @break

                                            @case('cartera')
                                                @if ($docuCartera)
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
                                                                <th scope="col" class="centrado font-sm">
                                                                    Días de retraso
                                                                </th>
                                                                <th scope="col" class="centrado font-sm">
                                                                    Saldo
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
                                                                    <th scope="row" class="derecha capitalize font-sm">
                                                                        @if ($item->fecha_pago < $fecha)
                                                                            @php
                                                                                $fecha1 = date_create($item->fecha_pago);
                                                                                $dias = date_diff($fecha1, $fecha)->format('%R%a');
                                                                            @endphp
                                                                            {{$dias}} días
                                                                        @endif
                                                                    </th>
                                                                    <th scope="row" class="derecha capitalize font-sm">
                                                                        $ {{number_format($item->saldo, 0, '.', '.')}}
                                                                    </th>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif

                                                @break

                                            @case('matricula')
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
                                                @break

                                            @default
                                                <div class="salto"></div>
                                        @endswitch
                                    @endif
                                @endforeach
                                <div class="salto"></div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>

            <div class="footer">
                <img class="imgfooter" src="{{public_path('img/pie.png')}}" alt="{{env('APP_NAME')}}">
            </div>
            @break
        @case(2)
            <div id="head">
                <img class="imgheader" src="{{public_path('img/encabezado.png')}}" alt="{{env('APP_NAME')}}">
            </div>

            <div class="marcagua">
                <img src="{{ public_path('img/logo.jpeg') }}" alt="marcagua" width="400">
            </div>

            @break
        @case(3)
            probando
            @break
    @endswitch

</body>
</html>

