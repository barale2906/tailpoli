<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Gestión de Graduaciones</h1>
    </div>
    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">
            @include('includes.filtro')
        </div>
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('inicia')">
                            Fecha Inicio
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Estudiante -- Matricula -- Fecha matricula
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Programación
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Asistencia - Notas
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('ultimo_pago')">
                            Último Pago
                            @if ($ordena != 'ultimo_pago')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('ultima_asistencia')">
                            Última Asistencia
                            @if ($ordena != 'ultima_asistencia')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('mora')">
                            Mora
                            @if ($ordena != 'mora')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('overol')">
                            Kit
                            @if ($ordena != 'overol')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('diploma')">
                            Diploma
                            @if ($ordena != 'diploma')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('ceremonia')">
                            Ceremonia
                            @if ($ordena != 'ceremonia')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('status_est')">
                            Estatus Estudiante
                            @if ($ordena != 'status_est')
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
                    @foreach ($singrados as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-blue-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <a href="" wire:click.prevent="show({{$item->matricula_id}},{{1}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <i class="fa-solid fa-book"></i>
                                        </a>
                                    </button>
                                    @can('ac_gestionCrear')
                                        <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-orange-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            <a href="" wire:click.prevent="show({{$item->id}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i>
                                            </a>
                                        </button>
                                    @endcan
                                    @can('ac_graduaciones_aprobar')
                                        <button type="button" class="inline-flex rounded-e-lg items-center p-2 text-sm font-medium text-gray-900 bg-green-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-2 focus:ring-green-700 focus:text-green-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-500 dark:focus:text-white">
                                            <a href="" wire:click.prevent="graduafun({{$item->id}})" class="inline-flex items-center font-medium text-green-600 dark:text-green-500 hover:underline">
                                                <i class="fa-solid fa-graduation-cap"></i>
                                            </a>
                                        </button>
                                        @if ($is_gradua && $crtid===$item->id)
                                            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                                                <label for="observaciones" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                    Observaciones:
                                                </label>
                                                <div class="relative z-0 w-full mb-5 group">
                                                    <input wire:model.live="observaciones" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                                                    <label for="observaciones" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Registrar</label>
                                                </div>
                                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                                    @if ($observaciones)
                                                        <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-green-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-2 focus:ring-green-700 focus:text-green-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-green-500 dark:focus:text-white">
                                                            <a href="" wire:click.prevent="graduaprueba" class="inline-flex items-center font-medium text-green-600 dark:text-green-500 hover:underline">
                                                                <i class="fa-solid fa-check"></i>
                                                            </a>
                                                        </button>
                                                    @endif
                                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-red-100 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-red-500 dark:focus:text-white">
                                                        <a href="" wire:click.prevent="cancela" class="inline-flex items-center font-medium text-red-600 dark:text-blue-500 hover:underline">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </a>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->inicia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white text-justify capitalize">
                                {{$item->estudiante->name}} -- {{$item->estudiante->documento}} -- Matricula: {{$item->matricula_id}} -- <br>{{$item->matricula->created_at}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->ciclo->name}}
                            </th>
                            <th scope="row" class="font-medium text-gray-900 dark:text-white capitalize pt-3 pb-3">

                                @if ($is_verasistencia && $crtid===$item->estudiante_id)

                                    <span class="bg-cyan-100 text-cyan-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-cyan-900 dark:text-cyan-300">
                                        <a href="#" wire:click.prevent="muestrasitencia({{$item->estudiante_id}},{{2}})" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                            <i class="fa-regular fa-calendar-minus"></i>
                                        </a>
                                    </span>
                                    <livewire:academico.asistencia.resumen :id="$crtid" />
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        <a href="#" wire:click.prevent="muestrasitencia({{$item->estudiante_id}},{{1}})" class="inline-flex items-center font-medium text-green-600 dark:text-green-500 hover:underline">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </a>
                                    </span>
                                @endif

                                @if ($is_vernotas && $crtid===$item->estudiante_id)

                                    <span class="bg-cyan-100 text-cyan-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-cyan-900 dark:text-cyan-300">
                                        <a href="#" wire:click.prevent="muestranota({{$item->estudiante_id}},{{2}})" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    </span>
                                    <livewire:academico.nota.resumen :id="$crtid" />
                                @else
                                    <span class="bg-green-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                        <a href="#" wire:click.prevent="muestranota({{$item->estudiante_id}},{{1}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <i class="fa-solid fa-chart-simple"></i>
                                        </a>
                                    </span>
                                @endif

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->ultimo_pago}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->ultima_asistencia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($item->mora, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->overol}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @if ($item->diploma)
                                    {{number_format($item->diploma, 0, ',', '.')}}
                                @else
                                    Aún no.
                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @if ($item->ceremonia)
                                    {{number_format($item->ceremonia, 0, ',', '.')}}
                                @else
                                    Aún no.
                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @foreach ($estados as $value)
                                    @if ($value->id===$item->status_est)
                                        {{$value->name}}
                                    @endif
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
                    {{ $singrados->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_document)
        <livewire:academico.matricula.documentos :elegido="$elegido" />
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
