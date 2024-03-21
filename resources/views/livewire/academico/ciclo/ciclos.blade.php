<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Programación</h1>
    </div>

    @if ($is_modify)
        <div class="flex justify-end mb-4 ">
            @include('includes.filtro')
            @can('ac_cicloCrear')
                <a href="#" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-plus"></i> crear
                </a>
            @endcan
            @can('ac_export')
                @if ($ciclos->count()<=1000)
                    <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-file-excel fa-beat"></i>
                    </a>
                @endif
            @endcan
        </div>
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Curso
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('name')">
                            Programación
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('inicia')">
                            Inicia
                            @if ($ordena != 'inicia')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('finaliza')">
                            Finaliza
                            @if ($ordena != 'finaliza')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('registrados')">
                            Alumnos Registrados
                            @if ($ordena != 'registrados')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('jornada')">
                            Jornada
                            @if ($ordena != 'jornada')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
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
                        <th scope="col" class="px-6 py-3">
                            Grupos
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ciclos as $ciclo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{-- @can('ac_cicloEditar')
                                    @if ($ciclo->status===1)
                                        <a href="" wire:click.prevent="show({{$ciclo}},{{0}})" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-marker"></i>
                                        </a>
                                    @endif
                                @endcan --}}
                                @can('ac_cicloReutilizar')
                                    <a href="" wire:click.prevent="show({{$ciclo->id}},{{1}})" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                        <i class="fa-brands fa-creative-commons-sa"></i>
                                    </a>
                                @endcan

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$ciclo->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$ciclo->curso->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$ciclo->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$ciclo->inicia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$ciclo->finaliza}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$ciclo->registrados}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @switch($ciclo->jornada)
                                    @case(1)
                                        Mañana
                                        @break
                                    @case(2)
                                        Tarde
                                        @break
                                    @case(3)
                                        Noche
                                        @break
                                    @case(4)
                                        Fin de semana
                                        @break

                                @endswitch
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @switch($ciclo->status)
                                    @case(1)
                                    Aprobado
                                        @break
                                    @case(2)
                                        Activo
                                        @break
                                    @case(3)
                                        Inactivo
                                        @break
                                @endswitch
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @foreach ($ciclo->ciclogrupos as $item)

                                    <div class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                            {{$item->grupo->name}}{{--
                                            <span class="inline-flex items-center justify-center w-4 h-4 ms-2 p-4 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                                                {{$item->inscritos}}
                                            </span> --}}
                                        </h5>
                                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                            Modulo: {{$item->grupo->modulo->name}}
                                        </p>
                                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                            Profesor: {{$item->grupo->profesor->name}}
                                        </p>
                                    </div>
                                @endforeach
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
                    {{ $ciclos->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_creating)
        <livewire:academico.ciclo.ciclos-crear />
    @endif

    @if ($is_editing)
        {{-- <livewire:academico.ciclo.ciclos-editar :elegido="$elegido" /> --}}
    @endif

    @if ($is_deleting)
        <livewire:academico.ciclo.ciclos-reutilizar :elegido="$elegido" />
    @endif

    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    console.log(variable['name'])
                    Swal.fire({
                        position: 'center-end',
                        icon: 'success',
                        title: variable['name'],
                        showConfirmButton: false,
                        timer: 2500
                    })
                });
            });
        </script>
    @endpush
</div>
