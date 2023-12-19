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
        @foreach ($detalles as $item)
            @if ($item['documento_id']===$mat->id)
                @switch($item['tipo'])
                    @case('titulo')
                        <h1 class="centrado">
                            {{$item['contenido']}}
                        </h1>
                        @break
                    @case('parrafo')
                        <p class="justificado">
                            {{$item['contenido']}}
                        </p>
                        @break
                @endswitch

                @if ($item['tipo']==='firma')
                    <div class="salto"></div>
                @endif
            @endif
        @endforeach

    @endforeach


</body>
</html>

