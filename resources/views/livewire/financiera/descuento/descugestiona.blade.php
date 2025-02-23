<div>
    <h1 class="text-center text-xl font-bold uppercase">
        @if ($actual)
            editar descuento
        @else
            crear descuento
        @endif
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 m-3">
        <div></div>
        <div>
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Nombre</label>
                <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del descuento" wire:model.blur="name">
                @error('name')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor</label>
                <input type="text" id="valor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del descuento" wire:model.blur="valor">
                @error('valor')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Tipo de descuento</label>
                <select wire:model.live="tipo" id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija ...</option>
                    @for ($i = 0; $i < count($descuentos); $i++)
                        <option value={{ $i }}>{{ $descuentos[$i] }}</option>
                    @endfor
                </select>
                @error('tipo')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="aplica" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Aplica para:</label>
                <select wire:model.live="aplica" id="aplica" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija ...</option>
                    @for ($i = 0; $i < count($aplicadescuento); $i++)
                        <option value={{ $i }}>{{ $aplicadescuento[$i] }}</option>
                    @endfor
                </select>
                @error('aplica')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            @if ($actual)
                <a href="#" wire:click.prevent="editar()" class="w-auto text-black bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-tags"></i> Editar Descuento
                </a>
            @else
                <a href="#" wire:click.prevent="new()" class="w-auto text-black bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-tags"></i> Crear Descuento
                </a>
            @endif
            <br>
            <a href="#" wire:click.prevent="regresar()" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
        @if ($actual)
            <div class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <a href="" wire:click.prevent="" >

                    <h5 class="mb-2 text-sm md:text-xl font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                        conceptos de pago
                    </h5>
                    @foreach ($conceptos as $item)
                        <p class="font-normal text-xs md:text-lg text-justify text-gray-700 dark:text-gray-400 capitalize">
                            <a href="" wire:click.prevent="cargar({{$item->id}})">
                                {{$item->name}} - <i class="fa-solid fa-check-double text-green-500 text-xs"></i>
                            </a>
                        </p>
                    @endforeach
                </a>
            </div>
            @if ($asignados)
                <div class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <a href="" wire:click.prevent="" >

                        <h5 class="mb-2 text-sm md:text-xl font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                            Asignados
                        </h5>
                        @foreach ($asignados as $item)
                            <p class="font-normal text-xs md:text-lg text-justify text-gray-700 dark:text-gray-400 capitalize">
                                <a href="" wire:click.prevent="eliminar({{$item->elegido}})">
                                    {{$item->name}} - {{$item->elegido}} - <i class="fa-solid fa-trash-can text-red-600 text-xs"></i>
                                </a>
                            </p>
                        @endforeach
                    </a>
                </div>
            @endif

        @endif

        <div></div>
    </div>
</div>
