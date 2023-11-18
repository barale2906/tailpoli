<div>
    <form wire:submit.prevent="new">
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
            <div class="mb-6">
                <label for="sede_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sede</label>
                <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elegir sede...</option>
                    @foreach ($sedes as $item)
                        <option value={{$item->id}}>Sede: {{$item->name}} - Ciudad: {{$item->sector->name}}</option>
                    @endforeach
                </select>
            </div>
            @if ($sede_id>0)
                <div class="mb-6">
                    <label for="curso_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Curso</label>
                    <select wire:model.live="curso_id" id="curso_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elegir curso...</option>
                        @foreach ($cursos as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($sede_id>0 && $curso_id>0 && $contar===0)

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Ciclo</label>
                    <input type="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="name">
                    @error('name')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="inicia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio</label>
                    <input type="date" id="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.live="inicia">
                    @error('inicia')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="finaliza" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Fecha de Finalización sugerida: <strong>{{$finalizaej}}</strong>
                    </label>
                    <input type="date" id="finaliza" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="finaliza">
                    @error('finaliza')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="jornada" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jornada</label>
                    <select wire:model.live="jornada" id="curso_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Defina Jornada</option>
                        <option value="1">Mañana</option>
                        <option value="2">Tarde</option>
                        <option value="3">Noche</option>
                        <option value="4">Fin de Semana</option>
                    </select>
                    @error('jornada')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif

        </div>

        @if ($jornada>0)
            <h1 class="text-center text-lg">
                Tenga presente que para el curso: <strong class="uppercase">{{$curso->name}}</strong> solamente hay <strong>{{$maximo}}</strong> módulos, que son:
            </h1>
            <h1 class="text-center text-lg">
                @foreach ($curso->modulos as $item)
                    <span class="bg-green-100 text-green-800 font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 uppercase">
                        {{$item->name}}
                    </span>
                @endforeach
            </h1>

            <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                        @foreach ($grupos as $item)
                            <a href="" wire:click.prevent="selGrupo({{$item['id']}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-regular fa-circle-check fa-beat-fade"></i> {{$item['name']}}
                            </a>
                        @endforeach
                    </div>

                @if (count($seleccionados)>0)
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                        @foreach ($seleccionados as $item)
                            <a href="" wire:click.prevent="elimGrupo({{$item['id']}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-trash-can fa-bounce"></i> {{$item['name']}}
                            </a>
                        @endforeach
                    </div>
                @else
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SI NO ELIGE MODULOS SE ENTENDERA QUE LOS INCLUYO TODOS</label>
                    </div>
                @endif
            </div>
        @endif
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">

            @if ($jornada>0 && count($seleccionados)>0)
                <div>
                    <button type="submit"
                    class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                    >
                        Nuevo Ciclo
                    </button>
                </div>
            @endif

            <div>
                <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </div>
        </div>
    </form>
</div>
