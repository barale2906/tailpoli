<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        <div class="mb-6">
            <label for="profesor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Profesor:</label>
            <select wire:model.live="profesor_id" id="profesor_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija Profesor...</option>
                @foreach ($profesores as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        @if ($profesor_id>0)
            <div class="mb-6">
                <label for="grupo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Grupo:</label>
                <select wire:model.live="grupo_id" id="grupo_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija Grupo...</option>
                    @foreach ($grupos as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        @if ($grupo_id>0)
            @if ($esquemas->count()>0)

                <div class="mb-6">
                    <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Elija esquema de notas:</label>
                    <select wire:model.live="notas" id="notas" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija esquema...</option>
                        @foreach ($esquemas as $item)
                            <option value={{$item->id}}>{{$item->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="sm:col-span-1 md:col-span-3 text-center">
                    <h1 class="font-semibold mb-2">
                        No existe esquema de calificaciones para este grupo por parte del profesor elegido, debe generarlo primero.
                    </h1>
                    <a href="{{route('academico.notas')}}"  class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Generar Esquema
                    </a>
                </div>
            @endif

        @endif



    </div>
    @if ($notas)
        <livewire:academico.nota.notas-editar :elegido="$notas" :cargar="1"/>
    @endif
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        @if ($notas)
            <div class="mb-6">
                <label for="calificaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar calificaciones</label>
                <input type="file" id="calificaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="calificaciones">
            </div>
        @endif
        @if ($calificaciones)
            <a href="#" wire:click.prevent="alarma" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Cargar Archivo
            </a>
        @endif
        @if ($alerta)

            <div id="alert-additional-content-2" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">¡ACCIÓN IRREVERSIBLE!</h3>
                </div>
                <div class="mt-2 mb-4 text-lg">
                    <p class="text-red font-bold uppercase">
                        Recuerde que las notas deben estar entre 0 y 5, de lo contrario generará errores el registro.
                    </p>
                    <p>
                        Al aceptar esta acción se borraran los registros de notas ya existentes de esta lista de notas para el grupo, profesor y esquema elegidos.
                    </p>
                    <p>
                        Asegurese de cargar dichos datos o de reemplazarlos por completo.
                    </p>
                    <p>
                        Al finalizar debe ir al Menú Acádemico/Notas - Asistencias para validar la aprobación del modulo respectivo por parte de cada estudiante.
                    </p>

                </div>
                <div class="flex">

                    <a href="" wire:click.prevent="importar" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 uppercase">
                        <i class="fa-solid fa-triangle-exclamation fa-beat-fade"></i> confirmar carga
                    </a>
                </div>
            </div>

        @endif
    </div>

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
                        timer: 3500
                    })
                });
            });
        </script>
    @endpush

</div>
