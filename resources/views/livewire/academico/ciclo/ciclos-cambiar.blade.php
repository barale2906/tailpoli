<div>
    <h2 class="text-center text-lg ">
        El estudiante: <span class="font-bold uppercase">{{$control->estudiante->name}}</span> esta inscrito en la programación: <span class="font-bold uppercase"> {{$control->ciclo->name}}</span> con los siguientes modulos:
        @foreach ($control->matricula->grupos as $item)
        <span class="font-bold uppercase">{{$item->modulo->name}}</span> /
        @endforeach, Seleccione la programación que mas se ajuste:
    </h2>


    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
        <div>
            @foreach ($ciclos as $item)
                <div class="col-span-1">

                    <a href="" wire:click.prevent="show({{$item->id}})" class="block max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                            {{$curso}}
                        </h5>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                            {{$item->name}}
                        </p>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                            Inicia: {{$item->inicia}} Finaliza: {{$item->finaliza}}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="sm:col-span-1 md:col-span-3">
            @if ($ciclo)
                <div class="relative overflow-x-auto">
                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" >
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                                    Duración
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                                    Sede
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                                    Grupo(s)
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" >

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$ciclo->name}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                    {{$ciclo->inicia}} - {{$ciclo->finaliza}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                    {{$ciclo->sede->name}}
                                </th>
                                <th scope="row" class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                    @foreach ($ciclo->ciclogrupos as $item)
                                        <a href="" wire:click.prevent="show({{$item->id}},{{1}})" class="block max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                            <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                                {{$item->name}}
                                            </h5>
                                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                                Modulo: {{$item->grupo->modulo->name}}
                                            </p>
                                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                                Profesor: {{$item->grupo->profesor->name}}
                                            </p>
                                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                                Inicia: {{$item->fecha_inicio}} Finaliza: {{$item->fecha_fin}}
                                            </p>
                                        </a>
                                    @endforeach
                                </th>
                                <th>
                                    <a href="" wire:click.prevent="cambiar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-4 capitalize">
                                        <i class="fa-solid fa-check-double"></i>
                                    </a>
                                    @if ($is_cambiar)
                                        <a href="#" wire:click.prevent="aprobar"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Confirme Cambio
                                        </a>
                                    @endif
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
