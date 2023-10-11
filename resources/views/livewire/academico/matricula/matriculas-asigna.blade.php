<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-5 justify-center gap-4">
        <div class="w-full p-4 col-span-3 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{$matricula->alumno->name}} </h5>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                Matricula N°: {{$matricula->id}}, documento del alumno N°: {{number_format($matricula->alumno->documento, 0, ',', '.')}}
            </p>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400 uppercase">
                <strong>{{$matricula->curso->name}}</strong>
            </p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                    Modulos de esta matricula
                </p>
                @foreach ($modulos as $item)
                    <a href="" wire:click.prevent="" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                        <i class="fa-solid fa-person-hiking fa-beat mr-3"></i>
                        <div class="text-left">
                            <div class="mb-1 text-lg font-semibold capitalize">{{$item->name}}</div>
                            <div class="-mt-1 font-sans text-sm ">
                                {{$item->aprobo ? "APROBADO": "POR VER"}}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="w-full p-1 col-span-2 text-center bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <p class="mb-5 text-base text-gray-500 md:text-lg dark:text-gray-400">
                Grupo(s) a los cuáles esta inscrito
            </p>
            @foreach ($matricula->grupos as $item)
                <div class="w-full p-1 text-center bg-white shadow ">
                    <a href="" wire:click.prevent="" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm text-center m-1 p-1 capitalize">
                        <i class="fa-solid fa-person-hiking fa-beat m-3"></i> {{$item->name}}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @if (count($disponibles)>0)
        <h6 class="block mb-2 text-md font-medium text-gray-900 dark:text-white">Elija los grupos que estime convenientes:</h6>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                    @foreach ($disponibles as $item)
                        <a href="" wire:click.prevent="selGrupo({{$item['id']}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-regular fa-circle-check fa-beat-fade"></i> {{$item['id']}} Modulo: {{$item['modulo']}} Grupo:{{$item['name']}} - Finaliza: {{$item['finish_date']}} - Inscritos: {{$item['inscritos']}}
                        </a>
                    @endforeach
                </div>
            @if (count($grupos)>0)
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                    @foreach ($grupos as $item)
                        <a href="" wire:click.prevent="elimGrupo({{$item['id']}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-trash-can fa-bounce"></i> {{$item['name']}}
                        </a>
                    @endforeach
                </div>
            @else
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ES NECESARIO ELEGIR UN GRUPO PARA CADA MODULO.</label>
                </div>
            @endif
        </div>
    @endif
    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4">
        @if (count($grupos)>0)
            <a href="" wire:click.prevent="asignar()" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Cargar Grupo(s)
            </a>
        @endif
        <a href="#" wire:click.prevent="$dispatch('grupos')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </div>
</div>
