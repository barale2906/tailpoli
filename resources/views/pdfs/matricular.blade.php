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
            CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCATIVOS N°: {{$id}}
        </div>
    </div>

    @foreach ($matr as $item)
        <p class="justificado">
            {{$item['contenido']}}
        </p>
    @endforeach

</body>
</html>

