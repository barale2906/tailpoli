<div>
    <form wire:submit.prevent="new">

        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
            <div class="mb-6">
                <select wire:model.live="sede_id" id="sede" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija sede...</option>
                    @foreach ($sedes as $item)
                        <option value={{$item->id}}>{{$item->name}} - {{$item->sector->name}}</option>
                    @endforeach
                </select>
                @error('sede_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="mb-6">
                <select wire:model.live="curso_id" id="curso" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize" >
                    <option >Elija curso...</option>
                    @foreach ($cursos as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('curso_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>
        @if ($curso_id>0)
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elija los modulos incluidos, si no selecciona los incluye todos</label>
            <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                        @foreach ($modulos as $item)
                            <a href="#" wire:click.prevent="selModulo({{$item['id']}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-regular fa-circle-check fa-beat-fade"></i> {{$item['name']}}
                            </a>
                        @endforeach
                    </div>

                @if (count($moduloDepen)>0)
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                        @foreach ($moduloDepen as $item)
                            <a href="#" wire:click.prevent="elimModulo({{$item['id']}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
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
        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m">
            <div class="mb-6">
                <label for="valor_curso" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor total del curso</label>
                <input type="number" id="valor_curso" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Costo del curso" wire:model.blur="valor_curso">
                @error('valor_curso')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="valor_matricula" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor de la matricula</label>
                <input type="number" id="valor_matricula" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Defina el valor de la matricula" wire:model.blur="valor_matricula">
                @error('valor_matricula')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="valor_cuota_inicial" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor cuota inicial</label>
                <input type="number" id="valor_cuota_inicial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Primer pago" wire:model.blur="valor_cuota_inicial" wire:keydown="calcuCuota()">
                @error('valor_cuota_inicial')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            @if ($valor_curso>0 && $valor_cuota_inicial<$valor_curso && $valor_cuota_inicial)
                <div class="mb-6">
                    <label for="cuotas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Número de cuotas{{$saldo>0 ? " Para: $ ".number_format($saldo, 0, '.', ' '):""}}</label>
                    <input type="number" id="cuotas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Número de cuotas" wire:model.blur="cuotas" wire:keydown="calcula()">
                    @error('cuotas')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif

            @if ($cuotas>0)
                <div class="mb-6">
                    <label for="valor_cuota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor cuota</label>
                    <input type="number" step="any" id="valor_cuota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor de la cuota" wire:model.blur="valor_cuota">
                    @error('valor_cuota')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif

        </div>
        <div class="mb-6">
            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Descripción</label>
            <input type="text" id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descripción de la configuración" wire:model.blur="descripcion">
            @error('descripcion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 m">
            <button type="submit"
            class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
            >
                Nueva Configuración de Pago
            </button>
            <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
    </form>
</div>
