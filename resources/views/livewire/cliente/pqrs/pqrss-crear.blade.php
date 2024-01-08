<div>
    @if ($ver)
        <div>
            @if ($estudiante_id && $origen===1)
                <h1 class=" text-center">
                    Va a generar un PQRS para <strong class=" text-lg uppercase font-extrabold">{{$alumnoName}}</strong>
                </h1>
            @endif
            <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 md:h-60">
                @if ($origen===1 && $estudents)
                    <div class="mb-6">
                        <div class="w-full">
                            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar Alumno</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input
                                    type="search"
                                    id="buscar"
                                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="digite nombre o documento del estudiante"
                                    wire:model="buscar"
                                    wire:keydown="buscAlumno()"
                                    autocomplete="off"
                                    >
                                <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600" wire:click="limpiar()">
                                    Limpiar Filtro
                                </button>
                            </div>
                        </div>
                        @if ($buscar)
                            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                @foreach ($estudents as $item)
                                    @if ($item->rol_id===6)
                                        <li class="w-full mt-2 mb-2 capitalize">
                                            {{$item->name}} - {{$item->documento}} <a href="#" wire:click.prevent="selAlumno({{$item}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                                                <i class="fa-solid fa-check fa-beat"></i> elegir
                                            </a>
                                        </li>
                                    @endif

                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif

                @if ($origen===2)
                    Estudiante: {{$this->actual->estudiante->name}}
                @endif


                @if ($origen<=2 || $editar)
                    @can('cl_pqrsAsig')
                        <div class="mb-6">
                            <label for="gestion_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Encargado</label>
                            <select wire:model.live="gestion_id" id="gestion_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option >Elegir...</option>
                                @foreach ($empleados as $item)
                                    <option value={{$item->id}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('gestion_id')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>
                    @endcan
                @endif

                @if ($estudiante_id)
                    <div class="mb-6">
                        <label for="opcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Opción</label>
                        <select wire:model.live="opcion" id="opcion" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elegir...</option>
                            @if (!$origen)
                                <option value=1>Gestión</option>
                            @endif
                            <option value=2>Petición</option>
                            <option value=3>Queja</option>
                            <option value=4>Reclamo</option>
                            <option value=5>Sugenrencia</option>
                            <option value=6>Felicitación</option>
                        </select>
                        @error('opcion')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif

                @if ($opcion)
                    <div class="mb-6">
                        <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de requerimiento</label>
                        <select wire:model.live="tipo" id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elegir...</option>
                            <option value=2>Pagos</option>
                            <option value=3>Notas</option>
                            <option value=4>Acádemico</option>
                            <option value=5>Profesor</option>
                            <option value=6>Planta</option>
                            <option value=7>Talleres </option>
                            <option value=8>Administración</option>
                            @if (!$origen)
                                <option value=9>Observador</option>
                            @endif
                            <option value=10>Prácticas Empresariales</option>
                        </select>
                        @error('tipo')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif
                @if ($tipo)
                    <div class="mb-6">
                        <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre Observaciones</label>
                        <textarea id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Información necesaria para la gestión." wire:model.live="observaciones">

                        </textarea>
                        @error('observaciones')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif
                @if ($editar)
                    <div class="mb-6">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                        <select wire:model.live="status" id="status" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elegir...</option>
                            <option value=1>Creado</option>
                            <option value=2>Asignado</option>
                            <option value=3>En Gestión</option>
                            <option value=4>Cerrado</option>
                        </select>
                        @error('status')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif
                @if ($observaciones && !$editar)
                    <div class="mb-6">
                        <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargue Archivo soporte</label>
                        <input type="file" id="archivo" accept="image/jpg, image/bmp, image/png, image/jpeg, .pdf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="archivo">
                        @error('archivo')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                        <div wire:loading wire:target="archivo" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
                    </div>

                @endif
                @if ($editar)
                    <div class="mb-6">
                        <label for="respuesta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargue Archivo respuesta</label>
                        <input type="file" accept="image/jpg, image/bmp, image/png, image/jpeg, .pdf" id="respuesta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="respuesta">
                        @error('respuesta')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                        <div wire:loading wire:target="respuesta" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
                    </div>
                @endif
            </div>
            <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
                @if ($editar)
                    <a href="" wire:click.prevent="edit()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Actualizar
                    </a>
                    @if ($actual->ruta_solicita)
                        <a href="{{Storage::url($actual->ruta_solicita)}}" target="_blank" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-binoculars"></i> Ver soporte de solicitud
                        </a>
                    @endif
                @else
                    <a href="" wire:click.prevent="new()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Crear
                    </a>
                @endif

                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </div>
            @if ($editar)
                <h2 class="text-justify text-lg font-semibold">
                    {{$this->actual->observaciones}}
                </h2>
            @endif

        </div>
    @else
        <div>
            <h2 class="text-justify text-lg font-semibold">
                Estudiante: {{$this->actual->estudiante->name}}
            </h2>
            <h2 class="text-justify text-lg font-semibold">
                Gestiono: {{$this->actual->gestion->name}}
            </h2>
            <h2 class="text-justify text-lg font-semibold">
                {{$this->actual->observaciones}}
            </h2>
            @if ($actual->ruta_solicita)
                <a href="{{Storage::url($actual->ruta_solicita)}}" target="_blank" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-binoculars"></i> Ver soporte de solicitud
                </a>
            @endif
            @if ($actual->ruta_respuesta)
                <a href="{{Storage::url($actual->ruta_respuesta)}}" target="_blank" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-binoculars"></i> ver soporte de respuesta
                </a>
            @endif


            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Volver
            </a>
        </div>
    @endif
</div>

