<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Impresión de graduaciones</title>
        <link rel="shortcut icon" href="{{public_path('img/icon.ico')}}">
        <style>
            @font-face {
                font-family: "MonotypeCorsiva";
                src: url("' . public_path('fonts/MonotypeCorsiva.ttf') . '") format("truetype");
            }

            @page {
                @if ($margensup == 100 && $diplomas==2)
                    margin-top: 13cm;
                    margin-right: 3cm;
                    margin-left: 3cm;
                    margin-bottom: 0.5cm;
                @endif

                @if ($margensup != 100 && $diplomas==2)
                    margin-top: 4.5cm;
                    margin-right: 0.9cm;
                    margin-left: 2.4cm;
                    margin-bottom: 0.5cm;
                @endif

                @if ($margensup == 100 && $diplomas==1)
                    margin-top: 10cm;
                    margin-right: 3.5cm;
                    margin-left: 3.5cm;
                    margin-bottom: 2cm;
                @endif

                @if ($margensup != 100 && $diplomas==1)
                    margin-top: 4.5cm;
                    margin-right: 0.9cm;
                    margin-left: 2.4cm;
                    margin-bottom: 0.5cm;
                @endif
            }

            .border {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0.2cm;
            }

            .justificado{
                text-align: justify;
            }

            .derecha{
                text-align: right;
            }

            .izquierda{
                text-align: left;
            }

            .centrado{
                text-align:center;
            }
            .capitalize{
                text-transform: capitalize;
            }
            .uppercase{
                text-transform: uppercase;
            }
            .font-l{
                font-size: large;
            }

            .font-xl{
                font-size: x-large;
            }

            .font-medium{
                font-size: medium;
            }
            .font-sm{
                font-size: small;
            }

            .font-titulo{
                font-family: Comic Sans MS, cursive;
                font-size: xx-large;
            }

            .font-subtitulo{
                font-style: italic;
                color: #A8518A;
            }

            .font-cursiva{
                font-style: italic;
            }

            .font-parrafo{
                font-family: Comic Sans MS, cursive;
            }

            .font-titulobtenido{
                color: #3E4095;
            }
            .font-monotype {
                font-family: "MonotypeCorsiva", sans-serif;
                font-weight: 900;
            }
            .bold{
                font-weight: 900;
            }

            .mt-2{
                margin-top: 2.2cm;
            }

            .mt-4{
                margin-top: 4cm;
            }

            .mt-1{
                margin-top: 0.5cm;
            }

            .mt-15{
                margin-top: 1.5cm;
            }

            .mb-15{
                margin-bottom: 1.5cm;
            }
            .celdafirma{
                width: 50%;
                height: auto;
            }
            .p-1{
                padding: 0.1cm;
                line-height: 1;
            }

            .p-5{
                padding: 0.5cm;
                line-height: 1;
            }
            p {
                padding: 0.1cm;
                margin: 0.1cm;
                line-height: 2;
            }

            h1 {
                font-size: large;
            }

            .imgfirma{
                width: 4cm;
            }
            .salto{
                page-break-after: always;
            }

            table{
                table-layout: auto;
                width: 100%;
                height: auto;
                border-collapse:collapse;
                border: 0.1mm;
            }

            .footer {
                bottom: 4cm;
                position: fixed;
                text-align: right;
                width: 100%;
                font-size: x-small;
            }
        </style>
    </head>
    <body>
        @foreach ($cuerpodocu as $item)
            @switch($item['tipo'])
                @case('titulo')
                    <h1 class="centrado uppercase font-xl">
                        {{$item['contenido']}}
                    </h1>
                    @break

                @case('titulo_obtenido')
                    <h1 class="centrado uppercase bold font-xl font-titulobtenido font-monotype">
                        {{$titulotec}}
                    </h1>
                    @break

                @case('titulo_obtepractico')
                    <h1 class="justificado uppercase bold font-medium">
                        {{$titulotec}}
                    </h1>
                    @break

                @case('subtitulo')
                    <div class="centrado uppercase font-xl font-subtitulo bold font-monotype">
                        {{$item['contenido']}}
                    </div>
                    @break

                @case('subnormal')
                    <div class="centrado uppercase font-xl bold">
                        {{$item['contenido']}}
                    </div>
                    @break

                @case('lineadocumento')
                    <div class="centrado font-sm capitalize p-1">
                        {{$item['contenido']}}
                    </div>
                    @break

                @case('espacios')
                    @for ($i = 1; $i < $item['contenido']; $i++)
                        <br>
                    @endfor
                    @break

                @case('parrafo')
                    <p class="justificado font-medium font-parrafo font-l">
                        {{$item['contenido']}}
                    </p>
                    @break

                @case('firma7')
                    <table >
                        <thead >
                            <tr>
                                <th scope="col" >
                                    <p class="justificado font-sm uppercase mt-1 p-5">
                                        Cordialmente:
                                    </p>

                                    <p class="justificado font-sm capitalize mt-1 p-5">
                                        Firma:
                                    </p>
                                    <div class="justificado p-5" >
                                        <img class="imgfirma" src="{{public_path('img/firma_directora.png')}}" alt="{{config('instituto.directora')}}">
                                    </div>

                                    <p class="justificado font-sm uppercase p-5">
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

                @case('firma9')
                    <p class="justificado font-medium font-parrafo font-l">
                        En constancia de lo anterior se firma el presente título, en Bogotá D.C, el {{$fechalarga}}
                    </p>
                    <table class="font-sm mt-4">
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
                                    DIRECTORA
                                </th>
                                <th scope="col" class="celdafirma uppercase centrado font-sm p-1">
                                    COORDINADOR
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div class="footer bold">
                        Anotado al folio: {{$folio}} del libro de Registro N°: 1 Acta N°: {{$acta}} a los {{$fechacta}}
                    </div>
                    <div class="salto"></div>
                    @break

                @case('firma10')
                    <table >
                        <thead >
                            <tr>
                                <th scope="col" >
                                    <div class="justificado">
                                        <img class="imgfirma" src="{{public_path('img/firma_directora.png')}}" alt="{{config('instituto.directora')}}">
                                    </div>

                                    <div class="justificado font-sm p-1">
                                        Firma <br>
                                        Directora General
                                    </div>
                                </th>
                                <th scope="col" >
                                    <div class="derecha font-sm p-1 font-cursiva">
                                        <br><br><br><br><br><br>
                                        Esta constancia se expide de acuerdo al Articulo 43 de la ley 115 y Art. 12 Dec. <br>
                                        <span class="uppercase">{{$ciudad}}</span>, {{$fechagrado}}

                                    </div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div class="salto"></div>
                    @break

                @case('firma11')
                    <p class="justificado font-medium">
                        En constancia se firma en BOGOTÁ D.C., a los {{$fechagrado}}
                    </p>
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
                                    DIRECTORA
                                </th>
                                <th scope="col" class="celdafirma uppercase centrado font-sm p-1">
                                    COORDINADOR
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div class="salto"></div>
                    @break

                @case('firma12')
                    <p class="justificado font-medium">
                        La anterior constancia se encuentra en el libro de registro N°: {{$libro}}, registro realizado a los {{$fechacta}}. Acta N°: {{$acta}},  folio: {{$folio}}.
                    </p>
                    <br>
                    <table >
                        <thead >
                            <tr>
                                <th scope="col" >
                                    <div class="justificado">
                                        <img class="imgfirma" src="{{public_path('img/firma_directora.png')}}" alt="{{config('instituto.directora')}}">
                                    </div>

                                    <div class="justificado font-sm p-1">
                                        {{config('instituto.directora')}} <br>
                                        Directora General
                                    </div>
                                </th>
                                <th scope="col" >

                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div class="salto"></div>
                    @break

                @case('temastecnico')
                    <table class="border">
                        <thead >
                            <tr>
                                <th scope="col" class="centrado font-l bold border">
                                    TEMAS DEL CURSO
                                </th>
                                <th scope="col" class="centrado font-l bold border">
                                    ASISTENCIA Y CAPACITACIÓN
                                </th>
                            </tr>
                            @foreach ($temas as $item)
                                <tr>
                                    <th scope="col" class="justificado font-medium border">
                                        {{$item->descripcion}}
                                    </th>
                                    <th scope="col" class="centrado font-medium border">
                                        APROBO
                                    </th>
                                </tr>
                            @endforeach

                        </thead>
                    </table>
                    @break

            @endswitch
        @endforeach
    </body>
</html>
