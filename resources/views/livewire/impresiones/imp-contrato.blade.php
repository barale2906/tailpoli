<div>
    @push('title')
        Contrato N°: {{$id}}
    @endpush

    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                        <a href="" wire:navigate>
                            <img class="h-12 w-16 rounded-sm" src="{{asset('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
                        </a>

                    </th>
                    <th scope="col" class="px-2 py-1">
                        <h1 class="text-center  font-extrabold uppercase text-xl">contrato de prestación de servicios educativos n°: {{$docuMatricula->id}}</h1>
                    </th>
                    <th scope="col" class="text-justify">
                        <h1 class="text-sm font-bold">Fecha:</h1>
                        <h1 class="text-sm font-bold">{{$docuTipo->fecha}}</h1>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col">
                        <p class="text-justify text-sm uppercase">
                            NOMBRE DEL CURSO: <strong>{{$docuMatricula->curso->name}}</strong>
                        </p>
                        <p class="text-justify text-sm">
                            Duración del curso: <strong>{{$docuMatricula->curso->duracion_horas}} horas / {{$docuMatricula->curso->duracion_meses}} meses</strong>
                        </p>
                        <p class="text-justify text-sm">
                            Lugar:
                            <strong>
                                {{$docuMatricula->sede->name}} - {{$docuMatricula->sede->sector->name}}
                                - {{$docuMatricula->sede->sector->state->name}}
                            </strong>
                        </p>
                        <p class="text-justify text-sm">
                            Valor:
                            <strong>
                                $ {{number_format($docuMatricula->valor, 0, '.', '.')}}
                            </strong>
                        </p>

                        <p class="text-justify text-sm">
                            Pagaré Autorizado N°: {{$docuMatricula->id}}
                        </p>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
