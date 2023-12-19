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
    @foreach ($matr as $mat)
        <div id="head">
            <img class="imgheader" src="{{public_path('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
            <div class="infoHeader">
                documento base
            </div>
        </div>
        {{$mat->titulo}} N°: {{$id}}
        @foreach ($detalles as $item)
            @if ($item['documento_id']===$mat->id)
                <p class="justificado">
                    {{$item['contenido']}}
                </p>
                @if ($item['tipo']==='firma')
                    <div class="salto"></div>
                @endif
            @endif

        @endforeach

    @endforeach


</body>
</html>

