<div>
    <h1 class="text-justify font-normal ">
        @if ($registro)
            <span class="uppercase">
                {{$actual->name}}
            </span>
        @endif
        Este estudiante es un caso especial por:
        @switch($actual->caso_especial)
            @case(1)
                <strong>
                    REPROBO MODULO,
                </strong>
                @break
            @case(2)
                <strong>
                    ESTUDIANTE REINTEGRADO(A),
                </strong>
                @break
        @endswitch Modulos a los cuales esta inscrito, elija uno para ver más detalles
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-2">
        <div class="sm:col-span-1 md:col-span-2">

            @foreach ($modulos as $item)

                <div style="cursor: pointer;" wire:click.prevent="elegirModulo({{$item->modulo_id}})" class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                        {{$item->name}}
                    </h5>
                    <p class="font-normal text-xs text-gray-700 dark:text-gray-400">
                        Observaciones: {{$item->observaciones}}
                    </p>
                    <p class="text-xs text-gray-700 dark:text-gray-400 uppercase font-extrabold">
                        Estado:
                        @if ($item->aprobo)
                            Aprobado
                        @else
                            sin aprobar
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
        <div class="sm:col-span-1 md:col-span-4">
            @if ($elegido)
                <h1>
                    Grupos del modulo <span class="uppercase">{{$elegido->name}}</span> a los cuales ha pertenecido.
                </h1>
                @foreach ($eleGrupo as $item)
                    <div class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                            {{$item->grupo}}
                        </h5>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400">
                            Profesor: {{$item->profesor}}
                        </p>
                        <p class="text-xs text-gray-700 dark:text-gray-400 uppercase font-extrabold">
                            Observaciones: {{$item->observaciones}}
                        </p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @if ($registro && $elegido)
        <h1 class="text-center text-lg font-semibold">
            A continuación se presentan los grupos disponibles para este modulo en las diferentes sedes.
        </h1>
        <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-2 bg-slate-300 rounded-lg p-2">

            <div class="sm:col-span-1 md:col-span-2">
                    @foreach ($ciclos as $item)
                        <div style="cursor: pointer;" wire:click.prevent="elegirCiclo({{$item->ciclo_id}})" class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                                {{$item->grupo->name}}
                            </h5>
                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400">
                                Inscritos: {{$item->grupo->inscritos}}
                            </p>
                            <p class="text-xs text-gray-700 dark:text-gray-400 uppercase font-extrabold">
                                Capacidad: {{$item->grupo->quantity_limit}}
                            </p>
                        </div>
                    @endforeach
            </div>
            <div class="sm:col-span-1 md:col-span-4">
                @if ($cicloEle)
                    <div style="cursor: pointer;" wire:click.prevent="inscribe({{$cicloEle->id}})" class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                            Programación: {{$cicloEle->name}}
                        </h5>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400">
                            Grupos:
                            @foreach ($cicloEle->ciclogrupos as $item)
                                <span class="uppercase"> Grupo: {{$item->grupo->name}} - Inicia: {{$item->fecha_inicio}} - Finaliza: {{$item->fecha_fin}} </span><br>
                            @endforeach
                        </p>
                        <p class="text-xs text-gray-700 dark:text-gray-400 uppercase font-extrabold">
                            Estudiantes registrados: {{$cicloEle->registrados}}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
