<div>
    <h1 class="text-justify font-normal ">
        Este estudiante es un caso especial por: @switch($actual->caso_especial)
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
</div>
