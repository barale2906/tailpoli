<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">
            Gestión de estudiantes
        </h1>
    </div>
    @if ($is_modify)
    <div class="flex justify-center mb-4 ">
        @if ($origen!==3)
            <div class="w-full">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input
                        type="search"
                        id="buscar"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por grupo o nombre estudiante o documento estudiante o método de pago"
                        wire:model="buscar"
                        wire:keydown="buscaText()"
                        >
                    <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600" wire:click="limpiar()">
                        Limpiar Filtro
                    </button>

                </div>
            </div>
        @endif

        @can('cl_pqrsCrear')
            <a href="" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center ml-1 mr-1 mb-2 capitalize" >
                <i class="fa-solid fa-file-circle-question"></i> Nuevo
            </a>
            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Volver
            </a>
        @endcan
    </div>
    <div class="relative overflow-x-auto">
        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" >

                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha')">
                        Fecha
                        @if ($ordena != 'fecha')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('tipo')">
                        Tipo
                        @if ($ordena != 'tipo')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                        Estudiante
                    </th>

                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                        Gestiona
                    </th>

                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                        Observaciones
                    </th>{{--

                    <th scope="col" class="px-6 py-3" >
                        Soporte
                    </th> --}}
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('status')">
                        Estado
                        @if ($ordena != 'status')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $registro)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if ($registro->status!==4 && $origen!==3)
                                @can('cl_pqrsEditar')
                                    <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                        <a href="#" wire:click.prevent="show({{$registro->id}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                            <i class="fa-solid fa-marker"></i>Editar
                                        </a>
                                    </span>
                                @endcan
                            @else
                                @if ($origen!==3)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        <a href="#" wire:click.prevent="show({{$registro->id}})" class="inline-flex items-center font-medium text-green-600 dark:text-orange-500 hover:underline">
                                            <i class="fa-solid fa-binoculars"></i>Ver
                                        </a>
                                    </span>
                                @endif

                            @endif

                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$registro->fecha}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">

                            @switch($registro->tipo)
                                @case(1)
                                    Gestión
                                    @break
                                @case(2)
                                    Pago
                                    @break
                                @case(3)
                                    Notas
                                    @break
                                @case(4)
                                    Acádemico
                                    @break
                                @case(5)
                                    Profesor
                                    @break
                                @case(6)
                                    Planta
                                    @break
                                @case(7)
                                    Talleres
                                    @break
                                @case(8)
                                    Administración
                                    @break
                                @case(9)
                                    Observador
                                    @break
                            @endswitch
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$registro->estudiante->name}}
                        </th>
                        <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize pt-3 pb-3">
                            {{$registro->gestion->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$registro->observaciones}}
                        </th>{{--
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$registro->ruta}}
                        </th> --}}
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            @switch($registro->status)
                                @case(1)
                                    Creado
                                    @break
                                @case(2)
                                    Asignado
                                    @break
                                @case(3)
                                    En gestión
                                    @break
                                @case(4)
                                    Cerrado
                                    @break
                            @endswitch
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-blue-100">
            <div>
                <label class="relative inline-flex items-center mb-4 cursor-pointer">
                    <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                    <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=15>15</option>
                        <option value=20>20</option>
                        <option value=50>50</option>
                        <option value=100>100</option>
                    </select>
                </label>
            </div>
            <div>
                {{ $registros->links() }}
            </div>
        </div>
    </div>
    @endif

    @if ($is_creating)
        <livewire:cliente.pqrs.pqrss-crear :origen="$origen" />
    @endif

    @if ($is_editing)
        <livewire:cliente.pqrs.pqrss-crear :elegido="$elegido" :origen="2" />
    @endif

    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    console.log(variable['name'])
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: variable['name'],
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
            });
        </script>
    @endpush
</div>
