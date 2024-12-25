<div class="border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
    <h1 class=" text-center font-bold uppercase mb-3">
        Ver / Cargar los documentos de {{$actual->user->name}}
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 mb-3">
        <div class="mb-6">
            <label for="fecha_documento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha del documento</label>
            <input type="date" id="fecha_documento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Salario básico" wire:model.blur="fecha_documento">
            @error('fecha_documento')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del documento</label>
            <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del documento" wire:model.blur="name">
            @error('name')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Tipo de documento</label>
            <select wire:model.live="tipo" id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija ...</option>
                @for ($i = 0; $i < count($documentosFuncionarios); $i++)
                    <option value={{$i}}>
                        {{$documentosFuncionarios[$i]}}
                    </option>
                @endfor
            </select>
            @error('tipo')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
            <label for="archivo" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                Seleccione el archivo
            </label>
            <div class="relative z-0 w-full mb-5 group">
                <input type="file" wire:model.live="archivo" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                <label for="archivo" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Archivo</label>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="new" class=" text-lg font-extrabold text-cyan-500">
        Gracias por esperar, cargando documento.
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 mt-3">
        @if ($archivo)
            <a href="" wire:click.prevent="new()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Guardar
            </a>
        @endif
        <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </div>

    <div class="relative overflow-x-auto">

        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" >

                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Nombre del documento
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Fecha del documento
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Tipo de documento
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Estatus
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Ver documento
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentos as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">

                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{$item->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->fecha_documento}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$documentosFuncionarios[$item->tipo]}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$estados[$item->status]}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            <a href="{{Storage::url($item->ruta)}}" target="_blank">
                                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-blue-400 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                    Ver
                                </button>
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
