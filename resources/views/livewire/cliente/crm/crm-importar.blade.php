<div>
    <h2 class="text-center text-lg font-semibold">Desde esta pantalla podrás cargar listado de probables clientes para su gestión.</h2>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
        <div class="sm:col-span-1 md:col-span-2 ring p-3">
            <h1 class="text-center m-2">
                Ten presente que estos son los campos que se deben subir y en este orden, NO COLOQUES ENCABEZADO EN LA TABLA.
            </h1>
            <label for="archivo" class="block m-2 text-sm font-medium text-gray-900 dark:text-white">Cargar clientes</label>
            <input type="file" id="archivo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="archivo">

            <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-2">
                @if ($archivo)
                    <a href="#" wire:click.prevent="importar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Cargar Archivo
                    </a>
                @endif
                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </div>


            <table class=" text-sm text-left text-gray-500 dark:text-gray-400 mb-4 mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-400 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            ID del usuario al que se le va a asignar
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            ID de la ciudad
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            nombre del curso
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            nombre del probable estudiante
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            telefono
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            correo electrónico
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="ring">
            <h2 class="text-center text-lg font-semibold">Verifica el ID del usuario a quien le vas a asignar</h2>
            <livewire:configuracion.user.users/>
        </div>
        <div class="ring">
            <h2 class="text-center text-lg font-semibold">Verifica el ID de las ciudades respectivas</h2>
            <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
                @foreach ($ciudades as $item)
                    <p class="capitalize text-justify">{{$item->id}} - {{$item->name}}</p>
                @endforeach
            </div>
        </div>

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
