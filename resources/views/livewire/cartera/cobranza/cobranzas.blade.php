<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Gestión de Cobranza</h1>
    </div>

    @if ($is_modify)
        @include('includes.filtro')
        <div class="relative md:overflow-x-auto">
            <table class=" text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('id')">
                            ID
                            @if ($ordena != 'id')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('curso_id')">
                            Curso
                            @if ($ordena != 'curso_id')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('sede_id')">
                            Sede
                            @if ($ordena != 'sede_id')
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('dias')">
                            Días
                            @if ($ordena != 'dias')
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
                            Gestión
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('saldo')">
                            Saldo
                            @if ($ordena != 'saldo')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('etapa')">
                            Étapa
                            @if ($ordena != 'etapa')
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
                    @foreach ($cobranzas as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-blue-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <a href="" wire:click.prevent="show({{$item->matricula_id}},{{5}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <i class="fa-solid fa-book"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="inline-flex rounded-e-lg items-center p-2 text-sm font-medium text-gray-900 bg-orange-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        @can('ac_gestionCrear')
                                            <a href="" wire:click.prevent="show({{$item->id}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i>
                                            </a>
                                        @endcan
                                    </button>
                                </div>

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{$item->curso->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{$item->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->alumno->name}} -- {{$item->alumno->documento}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify dark:text-white capitalize">
                                {{$item->dias}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify  dark:text-white capitalize">
                                {{$item->correos}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                $ {{number_format($item->saldo, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    @foreach ($item->cobracorres as $value)

                                        @switch($value->etapa)
                                            @case(1)
                                                <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-yellow-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-yellow-700 focus:z-10 focus:ring-2 focus:ring-yellow-700 focus:text-yellow-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-yellow-500 dark:focus:text-white">
                                                    <a href=""  class="inline-flex items-center font-medium text-yellow-600 dark:text-yellow-500 hover:underline">
                                                        {{$value->etapa}}
                                                    </a>
                                                </button>
                                                @break
                                            @case(2)
                                                <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-cyan-100 border border-gray-200  hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                                    <a href="#"  class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                                        {{$value->etapa}}
                                                    </a>
                                                </button>
                                                @break

                                            @case(3)
                                                <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-orange-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-orange-700 focus:z-10 focus:ring-2 focus:ring-orange-700 focus:text-orange-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                                    <a href=""  class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                        {{$value->etapa}}
                                                    </a>
                                                </button>
                                                @break
                                            @case(4)
                                                <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-red-100 border-t border-b  rounded-e-lg border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                                    <a href=""  class="inline-flex items-center font-medium text-red-600 dark:text-cyan-500 hover:underline">
                                                        {{$value->etapa}}
                                                    </a>
                                                </button>
                                                @break

                                        @endswitch

                                    @endforeach





                                </div>
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
                    {{ $cobranzas->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_observaciones)
        <livewire:academico.gestion.observaciones :elegido="$elegido" :ruta="$ruta"/>
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
