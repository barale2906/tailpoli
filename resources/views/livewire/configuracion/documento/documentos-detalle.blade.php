<div>

        <h2 class="text-center text-xl font-bold">
            Agregar / modificar los componentes del documento <strong class="uppercase">{{$actual->titulo}}</strong>
        </h2>
        <p class="text-center">
            El documento se encuentra en estado:
            <span class="uppercase">
                @switch($actual->status)
                    @case(1)
                        elaboración
                        @break
                    @case(2)
                        aprobado
                        @break

                    @case(3)
                        activo
                        @break
                    @case(2)
                        obsoleto
                        @break
                @endswitch
            </span>
        </p>

        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
            <div class="ring ring-yellow-300">
                <form wire:submit.prevent="new">
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                    <div class="mb-6">
                        <label for="tipodetalle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">tipo de detalle</label>
                        <select wire:model.live="tipodetalle" id="tipodetalle" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elija tipo de detalle a agregar...</option>
                            <option value="titulo">titulo</option>
                            <option value="clausula">clausula</option>
                            <option value="paragrafo">paragráfo</option>
                            <option value="paragrafo">paragráfo</option>
                        </select>
                        @error('tipodetalle')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>

                    @if ($tipodetalle)

                        <div class="mb-6">
                            <label for="orden" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Orden</label>
                            <input type="num" id="orden" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="orden dentro del documento" wire:model.blur="orden" >
                            @error('orden')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>

                        <div class="mb-6 col-span-2">

                            <label for="contenido" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">componente del documento</label>
                            <textarea id="contenido"
                                rows="4"
                                wire:model.live="contenido"
                                class="block p-2.5 w-full resize text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="registre la información">

                            </textarea>

                            @error('contenido')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>

                        <button type="submit"
                        class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                        >
                            <i class="fa-solid fa-plus"></i> Agregar Componente
                        </button>
                    </form>
                    @endif
                    @if ($registrados->count()>0)
                        <a href="" wire:click.prevent="finalizar" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-check-double"></i> Finalizar Documento
                        </a>
                    @endif
                </div>
                @if ($registrados)
                    <div class="relative overflow-x-auto">
                        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" >
                                        tipo de detalle
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        orden
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        contenido
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrados as $registrado)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <a href="" wire:click.prevent="editar({{$registrado->id}})" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                                <i class="fa-solid fa-marker"></i> {{$registrado->tipodetalle}}
                                            </a>

                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                            {{$registrado->orden}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                            {{$registrado->contenido}}
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="ring ring-yellow-300">
                <h3 class="text-justify text-lg p-1">
                    Por favor utilice las siguientes palabras clave para agregar campos de datos a sus documentos, por ejemplo si quiere que aparezca el nombre del estudiante copie y pegue la palabra clave: <strong>nombreEstu</strong>, es importante que las copie y pegue tal cual y como aparecen en esta lista.
                </h3>
                <div class="relative overflow-x-auto">
                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" >
                                    COMANDO
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    DESCRIPCIÓN
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($palabras as $palabra)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$palabra->palabra}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                        {{$palabra->descripcion}}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

</div>
