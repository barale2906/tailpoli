<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{public_path('img/icon.ico')}}">
        <link rel="stylesheet" href="{{public_path('css/pdf.css')}}">
    </head>
    <body>

        <div class="flex-container">
            <div class="card">
                <div class="container">
                    <table class="table">
                        <tr>
                            <td colspan="3"  class="centrado">
                                <img class="img" src="{{public_path('img/carnet.png')}}" alt="{{config('instituto.directora')}}">
                            </td>
                        </tr>
                        <tr>
                            <td class=" izquierda capitalize font-l bold">
                                nombre (s):
                            </td>
                            <td colspan="2" class="izquierda uppercase font-l bold">
                                {{$matricula->alumno->perfil->name}}
                            </td>
                        </tr>
                        <tr>
                            <td class=" izquierda capitalize font-l bold">
                                Apellidos:
                            </td>
                            <td colspan="2" class="izquierda uppercase font-l bold">
                                {{$matricula->alumno->perfil->lastname}}
                            </td>
                        </tr>
                        <tr>
                            <td class=" izquierda capitalize font-l bold">
                                Identificación:
                            </td>
                            <td colspan="2" class="izquierda uppercase font-l bold">
                                {{number_format($matricula->alumno->perfil->documento, 0, '.', ' ')}}
                            </td>
                        </tr>
                        <tr>
                            <td class=" izquierda capitalize font-l bold">
                                curso:
                            </td>
                            <td colspan="2" class="izquierda uppercase font-l bold">
                                {{$matricula->curso->name}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="container">
                    <table class="table">
                        <tr>
                            <td colspan="2" class="centrado font-l">
                                ESTE CARNET ES PERSONAL E INTRANSFERIBLE, EN CASO DE PERDIDA COMUNICARSE EN BOGOTÁ D.C. AL SIGUIENTE TEL: 601 732 7627
                            </td>
                            <td class="centrado ">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="centrado">
                                <img class="imgfirma" src="{{public_path('img/firma_directora.png')}}" alt="{{config('instituto.directora')}}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="font-l">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="centrado">
                                <img class="img" src="{{public_path('img/carnet-pie.png')}}" alt="{{config('instituto.directora')}}">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


    </body>
</html>
