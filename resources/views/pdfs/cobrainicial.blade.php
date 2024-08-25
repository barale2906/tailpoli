<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{$cobro->alumno->name}}: {{$cobro->matricula_id}}</title>
        <link rel="shortcut icon" href="{{public_path('img/icon.ico')}}">
        <link rel="stylesheet" href="{{public_path('css/pdf.css')}}">
    </head>
    <body>

        <div id="head">
            <img class="imgheader" src="{{public_path('img/encabezado.png')}}" alt="{{env('APP_NAME')}}">
        </div>

        <div class="marcagua">
            <img src="{{ public_path('img/logo.jpeg') }}" alt="marcagua" width="400">
        </div>

        <h1 class=" text-center uppercase font-extrabold">
            notificación
        </h1>

        <p class=" text-justify">
            Bogotá, {{$hoy}}
        </p>
        <p class=" text-justify">
            Señor(a):
        </p>
        <p class=" text-justify capitalize font-bold">
            {{$cobro->alumno->name}}
        </p>
        <p class=" text-justify capitalize">
            Documento: {{$cobro->alumno->perfil->tipo_documento}} - {{$cobro->alumno->documento}}
        </p>

        <p class=" text-justify uppercase font-bold">
            referencia: obligación número: {{$cobro->matricula_id}}
        </p>

        <p class=" text-justify capitalize font-bold">
            valor cartera vencida: valor en letras ($ {{number_format($cobro->saldo, 0, ',', '.')}})
        </p>

        <p class=" text-justify text-lg italic">
            “Actualmente su obligación se encuentra en mora de 150 días, motivo por el cual la información relativa al incumplimiento será enviada a la Central de Información Crediticia y de Riesgo. DATACREDITO Si tienen alguna inconformidad con esta información por favor comuníquese con nosotros”.
        </p>

        <p class=" text-justify text-lg">
            Usted tendrá un término máximo de tiempo de <span class=" font-extrabold">{{$cobro->diasreporte}}</span> días calendario contados a partir del envío de esta para realizar Acuerdo de Pago y/o la cancelación total de su deuda con nuestra entidad/empresa.
        </p>

        <p class=" text-justify text-lg">
            De acuerdo a la cláusula Decima del contrato de servicios Estudiantiles suscrito con el INSTITUTO POLIANDINO CENTRAL SAS, cualquier incumplimiento en los pagos acordados dentro de los programas académicos serán reportados, y divulgados a DATACREDITO Central de Información y de Riesgo, toda la información referente a mi comportamiento comercial. Lo anterior implica que el cumplimiento o incumplimiento de mis obligaciones se reflejará en las mencionadas bases de datos.
        </p>

        <p class=" text-justify text-lg">
            Cordialmente.
        </p>

        <p class=" text-justify text-lg mt-5">
            Departamento de Cartera
            Instituto Poliandino Central SAS
            TELEFONO 3218865136

        </p>

        <div class="footer">
            <img class="imgfooter" src="{{public_path('img/pie.png')}}" alt="{{env('APP_NAME')}}">
        </div>
    </body>
</html>
