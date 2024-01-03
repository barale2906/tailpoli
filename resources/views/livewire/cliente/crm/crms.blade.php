<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Clientes en Gestión</h1>
    </div>

    @if ($is_modify)

        <div class="flex justify-center mb-4 ">
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

            @can('cl_clientesCrear')
                <a href="" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center ml-1 mr-1 mb-2 capitalize" >
                    <i class="fa-solid fa-graduation-cap"></i> Nuevo
                </a>
            @endcan
            @can('cl_clientesCargar')
                <a href="" wire:click.prevent="$dispatch('cargando')" class="w-auto text-black bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm p-2 text-center ml-1 mr-1 mb-2 capitalize" >
                    <i class="fa-solid fa-user-ninja"></i> Cargar
                </a>
            @endcan


        </div>
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >

                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_carga')">
                            Fecha Carga Datos
                            @if ($ordena != 'fecha_carga')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_registro')">
                            Fecha Registro
                            @if ($ordena != 'fecha_registro')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_gestion')">
                            Fecha Última Gestión
                            @if ($ordena != 'fecha_gestion')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>

                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('name')">
                            Mes
                            @if ($ordena != 'mes')
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
                            Curso
                        </th>

                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Ciudad
                        </th>

                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('name')">
                            Nombre
                            @if ($ordena != 'name')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('telefono')">
                            Teléfono
                            @if ($ordena != 'telefono')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('email')">
                            Correo
                            @if ($ordena != 'email')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        {{-- <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('historial')">
                            Gestión
                            @if ($ordena != 'historial')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th> --}}
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Encargado(a)
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;">
                            Estatus
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($crms as $crm)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @can('cl_clientesEditar')
                                    <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                        <a href="#" wire:click.prevent="show({{$crm->id}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                            <i class="fa-solid fa-marker"></i>
                                        </a>
                                    </span>
                                @endcan
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$crm->fecha_carga}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$crm->fecha_registro}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$crm->fecha_gestion}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">

                                @switch($crm->mes)
                                    @case(1)
                                        Enero
                                        @break
                                    @case(2)
                                        Fbrero
                                        @break
                                    @case(3)
                                        Marzo
                                        @break
                                    @case(4)
                                        Abril
                                        @break
                                    @case(5)
                                        Mayo
                                        @break
                                    @case(6)
                                        Junio
                                        @break
                                    @case(7)
                                        Julio
                                        @break
                                    @case(8)
                                        Agosto
                                        @break
                                    @case(9)
                                        Septiembre
                                        @break
                                    @case(10)
                                        Octubre
                                        @break
                                    @case(11)
                                        Noviembre
                                        @break
                                    @case(12)
                                        Diciembre
                                        @break
                                @endswitch
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$crm->curso}}
                            </th>
                            <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize pt-3 pb-3">
                                {{$crm->sector->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$crm->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$crm->telefono}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$crm->email}}
                            </th>
                            {{-- <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize md:h-52 ">
                                <div class="overflow-auto hover:overflow-scroll">
                                    {{$crm->historial}}
                                </div>
                            </th> --}}
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$crm->gestiona->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">

                                @switch($crm->status)
                                    @case(1)
                                        Creado
                                        @break
                                    @case(2)
                                        Interesado
                                        @break

                                    @case(3)
                                        Pendiente por matricular
                                        @break

                                    @case(4)
                                        Declinado
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
                    {{ $crms->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_creating)
        <livewire:cliente.crm.crm-crear  />
    @endif

    @if ($is_editing)
        <livewire:cliente.crm.crm-crear :elegido="$elegido" />
    @endif

    @if ($is_charge)
        <livewire:cliente.crm.crm-importar />
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
