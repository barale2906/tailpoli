<div>

        <h2 class="text-center text-xl font-bold">
            Agregar / modificar los componentes del documento <strong class="uppercase">{{$actual->titulo}}</strong>
        </h2>
        <p class="text-center m-3">
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
            <a href="" wire:click.prevent="$dispatch('volver')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> Volver
            </a>
        </p>

        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-5">
            <div class="ring ring-yellow-300">
                <form wire:submit.prevent="new">
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                        @if ($actual->status===1)
                            <div class="mb-6">
                                <label for="tipodetalle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">tipo de detalle</label>
                                <select wire:model.live="tipodetalle" id="tipodetalle" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                    <option >Elija tipo de detalle a agregar...</option>
                                    <option value="titulo">titulo</option>
                                    <option value="ciudadfecha">ciudad y fecha de hoy</option>
                                    <option value="destinatario">Estudiante Destinatario (nombre - cédula)</option>
                                    <option value="parrafo">parráfo</option>
                                    <option value="parrafo1">parráfo con fondo gris claro</option>
                                    <option value="parrafo2">parráfo con tamaño de letra mas grande</option>
                                    <option value="linea">Línea constancia con fecha</option>
                                    <option value="linea1">Línea constancia  y acuerdo con fecha</option>
                                    <option value="firma1">firma estudiante (todos los datos)</option>
                                    <option value="firma2">firma estudiante (nombre - documento)</option>
                                    <option value="firma3">firma estudiante (lineas diligenciar)</option>
                                    <option value="firma4">firma estudiante con huella</option>
                                    <option value="firma5">firma estudiante con huella (lineas diligenciar)</option>
                                    <option value="firma6">firma departamento cartera</option>
                                    <option value="firma7">firma directora</option>
                                    <option value="firma8">firma estudiante - instituto</option>
                                    <option value="formaPago">forma de pago</option>
                                    <option value="horario">Horario</option>
                                    <option value="cartera">cartera</option>
                                    <option value="matricula">cuadro matricula</option>
                                    <option value="modulos">Insertar modulos del curso</option>
                                </select>
                                @error('tipodetalle')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                    </div>
                                @enderror
                            </div>

                        @endif

                        @if ($tipodetalle && $actual->status===1)

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
                                    rows="20"
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

                        @endif
                </form>
                        @if ($registrados->count()>0 && $actual->status===1)
                            <a href="" wire:click.prevent="finalizar" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-check-double"></i> Finalizar Documento
                            </a>

                        @endif
                    </div>
                @if ($registrados)
                    @if ($alerta)

                        <div id="alert-additional-content-2" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <h3 class="text-lg font-medium">¡ACCIÓN IRREVERSIBLE!</h3>
                            </div>
                            <div class="mt-2 mb-4 text-sm">
                                <p>
                                    Cuando finaliza la elaboración del documento <strong class="uppercase">{{$actual->titulo}}</strong> este entrará en vigencia en la fecha <strong>{{$actual->fecha}}</strong>
                                </p>

                                @if ($docuanterior)
                                    <p>
                                        con esta acción dejará obsoleto el documento {{$docuanterior->titulo}}, esto no borrará los documentos generados con dicha plantilla.
                                    </p>
                                @endif
                                <p>
                                    Los documentos que se generen a partir de dicha fecha usaran esta plantilla para su concepción.
                                </p>
                                <p>
                                    Si está <strong class="uppercase">seguro(a)</strong> de hacerlo de clic en el siguiente botón.
                                </p>

                            </div>
                            <div class="flex">

                                <a href="" wire:click.prevent="culminar" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 uppercase">
                                    <i class="fa-solid fa-check-double"></i> Finalizar Documento
                                </a>
                            </div>
                        </div>

                    @endif
                    @if ($actual->status!==1)
                        <div id="alert-additional-content-1" class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                            <div class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Utilizar este documento como base</h3>
                            </div>
                            <div class="mt-2 mb-4 text-sm">
                                Puede utilizar los datos de este documento para generar su reemplazo. Si así lo desea de clic en el siguiente botón:
                            </div>
                            <div class="flex">

                                <a href="" wire:click.prevent="$parent.usar({{$actual->id}})" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 uppercase">
                                    <i class="fa-solid fa-check-double"></i> Nuevo Documento
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="relative overflow-x-auto">
                        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" colspan="3" class="px-6 py-3 text-center" >
                                        <a href="{{$ruta}}" target="_blank" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 uppercase">
                                            <i class="fa-solid fa-link"></i> VER documento
                                        </a>
                                    </th>
                                </tr>
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
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            @if ($actual->status===1)
                                                <a href="" wire:click.prevent="editar({{$registrado->id}})" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">
                                                    <i class="fa-solid fa-marker"></i> {{$registrado->tipodetalle}}
                                                </a>
                                                <a href="" wire:click.prevent="eliminar({{$registrado->id}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            @else
                                                {{$registrado->tipodetalle}}
                                            @endif


                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                            {{$registrado->orden}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify dark:text-white ">
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
                <livewire:configuracion.documento.palabras  />
            </div>

        </div>

</div>
