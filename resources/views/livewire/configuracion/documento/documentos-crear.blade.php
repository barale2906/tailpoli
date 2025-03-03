<div>
    @if (!$detalles)
        <form wire:submit.prevent="new">

            <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
                <div class="mb-6">
                    <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Inicia Vigencia</label>
                    <input type="date" id="fecha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="fecha" >
                    @error('fecha')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">tipo de documento</label>
                    <select wire:model.live="tipo" id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija tipo de documento...</option>
                        @foreach ($documentos as $item)
                            <option value="{{$item->name}}">{{$item->name}} - {{$item->descripcion}}</option>
                        @endforeach
                    </select>
                    @error('tipo')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="control" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Control de impresión aplicable</label>
                    <select wire:model.live="control" id="control" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija control...</option>
                        @for ($i = 0; $i < count($statuscontrol); $i++)
                            <option value={{$i}}>{{$statuscontrol[$i]}}</option>
                        @endfor
                    </select>
                    @error('control')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                @if ($control==="2")
                    <div class="mb-6">
                        <label for="tipo_curso" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Documento para tipo de curso</label>
                        <select wire:model.live="tipo_curso" id="tipo_curso" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elija tipo curso...</option>
                            <option value=3>Indiferente</option>
                            <option value=2>Técnico</option>
                            <option value=1>Práctico</option>
                        </select>
                        @error('tipo_curso')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="orientacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Orientación de la impresión</label>
                        <select wire:model.live="orientacion" id="orientacion" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elija orientación...</option>
                            <option value=1>Vertical</option>
                            <option value=2>Horizontal</option>|
                        </select>
                        @error('orientacion')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="tamano" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Orientación de la impresión</label>
                        <select wire:model.live="tamano" id="tamano" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elija orientación...</option>
                            <option value=1>Carta</option>
                            <option value=2>Oficio</option>|
                        </select>
                        @error('tamano')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif

                <div class="mb-6">
                    <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Titulo del documento</label>
                    <input type="text" id="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba el titulo del documento" wire:model.live="titulo">
                    @error('titulo')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 m">
                <button type="submit"
                class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                >
                    Nuevo documento
                </button>
                <a href="#" wire:click.prevent="$dispatch('volver')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </div>
        </form>
    @endif

    @if ($detalles)
        <livewire:configuracion.documento.documentos-detalle :actual="$actual" />
    @endif
</div>
