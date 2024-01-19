<div>
    <div class="mb-6">
        <label for="tabla" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Tabla:</label>
        <select wire:model.live="tabla" id="tabla" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
            <option >Elija Tabla...</option>
            <option value=0>0 - Importar estudiantes</option>
            @foreach ($tablas as $item)
                <option value={{$item->id}}>{{$item->id}} - {{$item->migration}}</option>
            @endforeach
        </select>
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        @if ($tabla>=0)
            <div class="mb-6">
                <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar datos para la tabla</label>
                <input type="file" id="archivo" accept=".xls, .xlsx" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="archivo">
                @error('archivo')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
                <div wire:loading wire:target="archivo" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
            </div>
        @endif
        @if ($archivo)
            <a href="" wire:click.prevent="alarma" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
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
                    <h3 class="text-lg font-medium">¡ACCIÓN PELIGROSA!</h3>
                </div>
                <div class="mt-2 mb-4 text-lg">
                    <p class="text-red font-bold uppercase">
                        Verifique los datos a cargar son nuevos en la tabla respectiva.
                    </p>
                    <p>
                        Esta información puede estar relacionada con otras tablas, Asegurese de que es la correcta antes de ejecutar esta acción.
                    </p>
                    <p>
                        Si no tiene acceso al gestor de la base de datos, ABSTENGASE DE EJECUTARESTA ACCIÓN.
                    </p>

                </div>
                <div class="flex">

                    <a href="" wire:click.prevent="importar" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 uppercase">
                        <i class="fa-solid fa-triangle-exclamation fa-beat-fade"></i> confirmar carga
                    </a>
                </div>
            </div>

        @endif
        @if ($is_botones)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡Cargando!</span> Por favor espere...
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
                        timer: 1500
                    })
                });
            });
        </script>
    @endpush
</div>
