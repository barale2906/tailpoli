<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Impresión de graduaciones</title>
        <link rel="shortcut icon" href="{{public_path('img/icon.ico')}}">
        <style>
            @page {
                @if ($margensup == 100)
                    margin-top: 10cm;  /* Margen superior de 10 cm */
                @else
                    margin-top: 2.5cm;  /* Margen por defecto */
                @endif

                margin-bottom: 0.5cm;  /* Margen inferior fijo */
            }
        </style>
    </head>
    <body>
        @foreach ($cuerpodocu as $item)
            @switch($item->tipo)
                @case('')

                    @break

            @endswitch
        @endforeach
    </body>
</html>
