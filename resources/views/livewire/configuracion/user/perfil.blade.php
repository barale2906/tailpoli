<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-7 gap-4 m-2">
        <div></div>
        <div class="sm:grid-cols-1 md:col-span-5">
            <div id="alert-additional-content-1" class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-100 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium text-center">
                        Estas visitando el perfil de <strong class="uppercase">{{$actual->name}}</strong> con el rol de: <strong class="uppercase">{{$actual->roles[0]['name']}}</strong> y su estado actual es: <strong class="uppercase">{{$actual->perfil->estado->name}}</strong>
                    </h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    Está inscrito(a) en los cursos:
                </div>
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-1">
                    @foreach ($matriculas as $item)
                        <div>{{$item->curso->name}}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <div></div>
    </div>

    @if ($perf===0)

        <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-1">
            <a href="" wire:click.prevent="show(1)" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center m-1 capitalize">
                <i class="fa-solid fa-key"></i> Cambiar Contraseña
            </a>
            @if ($actual->rol_id<6)
                <a href="" wire:click.prevent="show(2)" class="text-black bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center m-1 capitalize">
                    <i class="fa-solid fa-building"></i> Sedes
                </a>
                <a href="" wire:click.prevent="show(3)" class="text-black bg-gradient-to-r from-cyan-500 via-cyan-600 to-cyan-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-400 dark:focus:ring-cyan-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center m-1 capitalize">
                    <i class="fa-solid fa-comment-dollar"></i> Salarios
                </a>
                <a href="" wire:click.prevent="show(4)" class="text-black bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-100 dark:focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center m-1 capitalize">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Cargar Soportes
                </a>
                <a href="" wire:click.prevent="show(5)" class="text-black bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-100 dark:focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center m-1 capitalize">
                    <i class="fa-solid fa-people-group"></i> Ver Beneficiarios
                </a>
                <a href="" wire:click.prevent="show(6)" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center m-1 capitalize">
                    <i class="fa-solid fa-file-signature"></i> Historial de Contratación
                </a>
            @endif
        </div>

        @if ($is_contrasena)
            <div class="bg-blue-50 border-blue-500 mb-3 p-2 rounded-xl">
                <livewire:configuracion.user.contrasena :elegido="$elegido"/>
            </div>
        @endif

        @if ($is_salarios)
            <div class="bg-blue-50 border-blue-500 mb-3 p-2 rounded-xl">
                <livewire:humana.salario.salarios :elegido="$elegido"/>
            </div>
        @endif

        @if ($is_documentos)
            <livewire:humana.documento.documentos :elegido="$elegido"/>
        @endif

        @if ($is_familias)
            <livewire:humana.familia.familias :elegido="$elegido"/>
        @endif

        @if ($is_contratos)
            <livewire:humana.contrato.contratos :elegido="$elegido"/>
        @endif

    @endif
    @can('co_userCrear')
        @if ($is_sedes)
            <livewire:configuracion.user.perfil-sedes :elegido="$elegido"/>
        @endif
    @endcan
    <form wire:submit.prevent="edit">

        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
            <div class="sm:grid-cols-1 md:col-span-5">
                <h3 class="text-lg font-medium text-center">Datos Básicos</h3>
            </div>
            <div class="mb-6">
                <label for="country_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País Nacimiento</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="country_id" wire:change="pais">
                    <option>Seleccione...</option>
                    @foreach ($countries as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('country_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="state_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento Nacimiento</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="state_id" wire:change="depto">
                    <option>Seleccione...</option>
                    @foreach ($states as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('state_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="sector_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad Nacimiento</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="sector_id">
                    <option>Seleccione...</option>
                    @foreach ($sectors as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('sector_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6 ">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Usuario</label>
                <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="name">
                @error('name')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellido del Usuario</label>
                <input type="text" id="lastname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Apellido" wire:model.blur="lastname">
                @error('lastname')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6 ">
                <label for="fecha_nacimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="fecha_nacimiento">
                @error('fecha_documento')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="tipo_documento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de documento</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="tipo_documento">
                    <option>Seleccione...</option>
                    <option value="cédula de ciudadanía">Cédula de Ciudadanía</option>
                    <option value="cédula de extranjería">Cédula de Extranjería</option>
                    <option value="tarjeta de identidad">Tarjeta de Identidad</option>
                    <option value="registro civil">Registro Civil</option>
                    <option value="pasaporte">Pasaporte</option>
                </select>
                @error('tipo_documento')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="documento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Documento de identidad</label>
                <input type="text" id="documento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="numero de cc, ti, etc" wire:model.blur="documento">
                @error('documento')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6 ">
                <label for="fecha_documento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Expedición</label>
                <input type="date" id="fecha_documento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="fecha_documento">
                @error('fecha_documento')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6 ">
                <label for="lugar_expedicion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lugar de Expedición</label>
                <input type="text" id="lugar_expedicion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="lugar_expedicion">
                @error('lugar_expedicion')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="genero" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Genero</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="genero">
                    <option>Seleccione...</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                </select>
                @error('genero')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="estado_civil" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado Civil</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="estado_civil">
                    <option>Seleccione...</option>
                    <option value="Casado">Casado</option>
                    <option value="Divorciado">Divorciado</option>
                    <option value="Separado">Separado</option>
                    <option value="Soltero">Soltero</option>
                    <option value="Unión Libre">Unión Libre</option>
                    <option value="Viudo">Viudo</option>
                    <option value="Sin Información">Sin Información</option>
                </select>
                @error('estado_civil')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        @if ($rol==="Estudiante")
            @can('ac_estudianteCrear')
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
                    <div class="sm:grid-cols-1 md:col-span-2">
                        <h3 class="text-lg font-medium text-center">Persona Multicultural</h3>
                    </div>
                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
                        @foreach ($registro as $item)
                            <a href="" wire:click.prevent="selGrupo({{$item['id']}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-regular fa-circle-check fa-beat-fade"></i> {{$item['name']}}
                            </a>
                        @endforeach
                    </div>
                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
                        @if (count($disponibles))
                            @foreach ($disponibles as $item)
                                <a href="" wire:click.prevent="elimGrupo({{$item['id']}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-trash-can fa-bounce"></i> {{$item['name']}}
                                </a>
                            @endforeach
                        @else
                            <h3 class="text-md font-medium text-center col-span-3 capitalize">No pertenece a ningún grupo Multicultural</h3>
                        @endif
                    </div>
                </div>
            @endcan
        @endif


        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
            <div class="sm:grid-cols-1 md:col-span-5">
                <h3 class="text-lg font-medium text-center">Datos de Contacto</h3>
            </div>
            <div class="mb-6 sm:grid-cols-1 md:col-span-3">
                <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                <input type="text" id="direccion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="direccion">
                @error('direccion')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6 sm:grid-cols-1 md:col-span-2">
                <label for="barrio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barrio</label>
                <input type="text" id="barrio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="barrio">
                @error('barrio')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="estrato" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estrato</label>
                <input type="text" id="estrato" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="estrato">
                @error('estrato')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electrónico</label>
                <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Correo Electrónico" wire:model.blur="email">
                @error('email')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="celular" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Celular</label>
                <input type="text" id="celular" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="celular">
                @error('celular')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="wa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Whats App</label>
                <input type="text" id="wa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="wa">
                @error('wa')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="fijo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono Fijo</label>
                <input type="text" id="fijo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="fijo">
            </div>

            @if ($tipo_documento === "tarjeta de identidad" || $tipo_documento ==="registro civil")

                <div class="mb-6 sm:grid-cols-1 md:col-span-3">
                    <label for="contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Persona de contacto</label>
                    <input type="text" id="contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="contacto" required>
                    @error('contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="documento_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Documento Contacto</label>
                    <input type="text" id="documento_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="documento_contacto" required>
                    @error('documento_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="email_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electrónico Contacto</label>
                    <input type="email" id="email_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Correo Electrónico" wire:model.blur="email_contacto">
                    @error('email_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="parentesco_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Parentesco</label>
                    <input type="text" id="parentesco_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="parentesco_contacto" required>
                    @error('parentesco_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="telefono_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono Contacto</label>
                    <input type="text" id="telefono_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="telefono_contacto" required>
                    @error('telefono_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

            @else
                <div class="mb-6 sm:grid-cols-1 md:col-span-3">
                    <label for="contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Persona de contacto</label>
                    <input type="text" id="contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="contacto" >
                    @error('contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="documento_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Documento Contacto</label>
                    <input type="text" id="documento_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="documento_contacto">
                    @error('documento_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="email_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electrónico Contacto</label>
                    <input type="email" id="email_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Correo Electrónico" wire:model.blur="email_contacto">
                    @error('email_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="parentesco_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Parentesco</label>
                    <input type="text" id="parentesco_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="parentesco_contacto">
                    @error('parentesco_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="telefono_contacto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono Contacto</label>
                    <input type="text" id="telefono_contacto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="telefono_contacto">
                    @error('telefono_contacto')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

            @endif


        </div>

        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
            <div class="sm:grid-cols-1 md:col-span-5">
                <h3 class="text-lg font-medium text-center">Salud y Otros Datos</h3>
            </div>
            <div class="mb-6">
                <label for="regimen_salud_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Regímen de salud</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="regimen_salud_id">
                    <option>Seleccione...</option>
                    @foreach ($regimenes as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('regimen_salud_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="discapacidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discapacidad</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="discapacidad">
                    <option>Seleccione...</option>
                    <option value="No Aplica">No Aplica</option>
                    <option value="Baja Visión Diagnóstica">Baja Visión Diagnóstica</option>
                    <option value="Ceguera">Ceguera</option>
                    <option value="Deficiencia Cognitiva">Deficiencia Cognitiva</option>
                    <option value="Hipoacucia - Baja Audición">Hipoacucia - Baja Audición</option>
                    <option value="Lesión Neuromuscular">Lesión Neuromuscular</option>
                    <option value="Parálisis Cerebral">Parálisis Cerebral</option>
                    <option value="Sordera Profunda">Sordera Profunda</option>
                </select>
                @error('discapacidad')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="arl_usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ARL</label>
                <input type="text" id="arl_usuario" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="arl_usuario">
                @error('arl_usuario')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="rh_usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RH / Grupo Sanguíneo</label>
                <input type="text" id="rh_usuario" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="rh_usuario">
                @error('rh_usuario')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="nivel_educativo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nivel Educativo</label>
                <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="nivel_educativo">
                    <option>Seleccione...</option>
                    @for ($i = 0; $i < count($escolaridad); $i++)
                        <option value={{$escolaridad[$i]}}>
                            {{$escolaridad[$i]}}
                        </option>
                    @endfor
                </select>
                @error('nivel_educativo')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            {{--
            <div class="mb-6">
                <label for="talla" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Talla</label>
                <input type="text" id="talla" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="talla">
            </div>
            <div class="mb-6">
                <label for="calzado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Calzado</label>
                <input type="text" id="calzado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="calzado">
            </div> --}}
        </div>

        @if ($rol==="Estudiante")
            <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
                <div class="sm:grid-cols-1 md:col-span-5">
                    <h3 class="text-lg font-medium text-center">Datos Laborales</h3>
                </div>
                <div class="mb-6">
                    <label for="ocupacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ocupación</label>
                    <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="ocupacion">
                        <option>Seleccione...</option>
                        <option value="Empleado">Empleado</option>
                        <option value="Estudiante Básica / Media">Estudiante Básica / Media</option>
                        <option value="Estudiante Superior">Estudiante Superior</option>
                        <option value="Desempleado">Desempleado</option>
                        <option value="Independiente">Independiente</option>
                        <option value="Pensionado">Pensionado</option>
                        <option value="Sin Información">Sin Información</option>
                    </select>
                    @error('ocupacion')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="empresa_usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Empresa Donde Trabaja</label>
                    <input type="text" id="empresa_usuario" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="empresa_usuario">
                    @error('empresa_usuario')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="autoriza_imagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Autoriza el uso de la imágen</label>
                    <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="autoriza_imagen">
                        <option>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="carnet" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Posee Carnet Estudiantil</label>
                    <select class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="carnet">
                        <option>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                    @error('carnet')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="sorteo_usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de Ticket (sorteo):</label>
                    <input type="text" id="sorteo_usuario" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.blur="sorteo_usuario">
                </div>
            </div>
        @endif

        @if ($rol!=="Estudiante")
            <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">

                <div class="mb-6">
                    <label for="habilidades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre habilidades y conocimientos</label>
                    <textarea id="habilidades" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Habilidades importantes" wire:model.live="habilidades">

                    </textarea>
                </div>
                <div class="mb-6">
                    <h2 class="text-justify text-xl ">
                        {{$this->actual->perfil->habilidades}}
                    </h2>
                </div>


            </div>
        @endif

        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
            <button type="submit"
            class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
            >
                Editar Ficha
            </button>
            @if ($perf===0)
                <a href="" wire:click.prevent="$dispatch('Perfilando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                </a>
            @endif
            @if ($ruta===2)
                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                </a>
            @endif
            <a href="/impresiones/impperfil?o={{$impresion}}&u={{$actual->id}}" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-print"></i> Imprimir
            </a>

        </div>
    </form>
    @if ($perf===1)
        <h3 class="text-3xl font-medium text-center uppercase m-4">administración de la cuenta</h3>
    @endif
    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    console.log(variable['name'])
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: variable['name'],
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
            });
        </script>
    @endpush
</div>
