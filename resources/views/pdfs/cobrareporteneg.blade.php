<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{$cobro->alumno->name}}: {{$cobro->matricula_id}}</title>
        <link rel="shortcut icon" href="{{public_path('img/icon.ico')}}">
        <link rel="stylesheet" href="{{public_path('css/pdf.css')}}">
        <link href="{{ asset('build/assets/app-fa36c09a.css') }}" rel="stylesheet">
        <script src="{{ asset('build/assets/app-e201fd2b.js') }}" defer></script>
    </head>
    <body>

        <div id="head">
            <img class="imgheader" src="{{public_path('img/encabezado.png')}}" alt="{{env('APP_NAME')}}">
        </div>

        <div class="marcagua">
            <img src="{{ public_path('img/logo.jpeg') }}" alt="marcagua" width="400">
        </div>

        <h1 class=" text-center uppercase font-extrabold text-3xl mt-4 text-red-500">
            <span class=" text-red-700">notificación</span>
        </h1>

        <div class=" text-justify font-sans text-[12px] leading-normal">
            <p class=" mt-3">
                Bogotá, {{$fechaletras}}
            </p>
            <p class=" font-arial capitalize mt-2">
                Señor(a):<br>
                <span class="font-bold">{{$cobro->alumno->name}}</span><br>
                Documento: {{$cobro->alumno->perfil->tipo_documento}} - {{$cobro->alumno->documento}}
            </p>

            <p class="  uppercase font-bold mt-1">
                referencia: obligación número: {{$cobro->matricula_id}}.<br>
                <span class=" capitalize">valor cartera vencida: {{$fopaLetVr}} ($ {{number_format($cobro->saldo, 0, ',', '.')}}).</span>
            </p>

            <p class="mt-2 font-extrabold text-center">
                Usted ha sido reportado negativamente a centrales de riesgo, lo invitamos a conciliar su cartera.
            </p>

            <p class="mt-2">
                Usted ha sido reportado negativamente a centrales de riesgo, lo invitamos a conciliar su cartera. Actualmente su obligación se encuentra en mora de {{$cobro->dias}} días, motivo por el cual la información relativa al incumplimiento será enviada a <span class=" font-bold">DATACREDITO Central de Información Crediticia y de Riesgo</span> Si tienen alguna inconformidad con esta información por favor comuníquese con nosotros”.
            </p>


            <p class="mt-2">
                De acuerdo a la cláusula Decima del contrato de servicios Estudiantiles suscrito con el INSTITUTO POLIANDINO CENTRAL SAS, cualquier incumplimiento en los pagos acordados dentro de los programas académicos serán reportados, y divulgados a <span class=" font-bold">DATACREDITO Central de Información y de Riesgo</span>, toda la información referente a mi comportamiento comercial. Lo anterior implica que el cumplimiento o incumplimiento de mis obligaciones se reflejará en las mencionadas bases de datos.
            </p>
            <p class="mt-2">
                ¡Comuníquese con nosotros lo más pronto posible para evitar este registro!
            </p>

            <p class="mb-6 mt-11">
                Cordialmente.
            </p>

            <p class=" mt-7">
                Departamento de Cartera<br>
                Instituto Poliandino Central SAS<br>
                TELEFONO 3218865136
            </p>

        </div>

        <div class="footer">
            <img class="imgfooter" src="{{public_path('img/pie.png')}}" alt="{{env('APP_NAME')}}">
        </div>
    </body>
</html>
