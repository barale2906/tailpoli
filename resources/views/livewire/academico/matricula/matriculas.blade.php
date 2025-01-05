<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Matriculas</h1>
    </div>

    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">


            @include('includes.filtro')
            @if (!$reportes)
                @include('includes.matriculasresumen')
            @endif

            @if ($reportes)
                @can('ac_matriculaCrear')
                    <a href="#" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-plus"></i> crear
                    </a>
                @endcan

                @can('ac_matriculaCrear')
                    <a href="" wire:click.prevent="$dispatch('especia')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-book-medical"></i> Casos Especiales
                    </a>
                @endcan
            @endif

            @can('ac_export')
                @if ($matriculas->count()<=1000)
                    <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-file-excel fa-beat"></i>
                    </a>
                    <div wire:loading wire:target="exportar" class="text-center text-sm font-extrabold text-red-500 capitalize">¡Por favor espere! Generando documento...</div>
                @endif

            @endcan
        </div>
        <div class="relative overflow-x-auto">

            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('created_at')">
                            Fecha Creación
                            @if ($ordena != 'created_at')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_inicia')">
                            Fecha Inicia
                            @if ($ordena != 'fecha_inicia')
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
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Curso
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Grupo(s)
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Estudiante
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor')">
                            Valor
                            @if ($ordena != 'valor')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('metodo')">
                            Método de Pago
                            @if ($ordena != 'metodo')
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
                            Matriculo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matriculas as $matricula)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    <a href="" wire:click.prevent="show({{$matricula->id}},{{4}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <i class="fa-solid fa-book"></i> - {{$matricula->id}}
                                    </a>
                                </span>
                                @if ($matricula->status_est===2)
                                    <button type="button" class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium text-gray-900 bg-red-100 border-t border-b border-red-200 hover:bg-red-100 hover:text-red-700 focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-red-500 dark:focus:text-white">
                                        <a href="" wire:click.prevent="show({{$matricula->alumno_id}},{{5}})" class="inline-flex items-center font-medium text-red-600 dark:text-red-500 hover:underline">
                                            <i class="fa-solid fa-circle-radiation"></i>
                                        </a>
                                    </button>
                                @endif

                                @if ($matricula->status)
                                    @can('ac_matriculaAnular')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                            <a href="#" wire:click.prevent="show({{$matricula}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('ac_grupoAsignar')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                            <a href="#" wire:click.prevent="show({{$matricula}},{{3}})" class="inline-flex items-center font-medium text-red-600 dark:text-red-500 hover:underline">
                                                <i class="fa-solid fa-retweet"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('ac_grupoAsignar')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                            <a href="#" wire:click.prevent="show({{$matricula->id}},{{6}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-person-dots-from-line"></i>
                                            </a>
                                        </span>
                                    @endcan
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                        <i class="fa-solid fa-plane-circle-xmark mr-2"></i>{{$matricula->id}}
                                    </span>
                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{$matricula->created_at}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$matricula->fecha_inicia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$matricula->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$matricula->curso->name}}
                            </th>
                            <th scope="row" class="px-1 py-1 font-medium text-gray-900  dark:text-white capitalize">


                                @if ($matricula->anula)
                                    {{$matricula->anula}} -por:  {{$matricula->anula_user}}
                                @else
                                    @if ($is_vergrupo && $crtid===$matricula->id)
                                        <span class="bg-cyan-100 text-cyan-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-cyan-900 dark:text-cyan-300">
                                            <a href="#" wire:click.prevent="muestragrupo({{$matricula->id}},{{2}})" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </a>
                                        </span>
                                        @foreach ($matricula->grupos as $item)
                                            <a href="" wire:click.prevent="show({{$item->id}},{{1}})" class="block max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                                <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                                    {{$item->name}}
                                                </h5>
                                                <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                                    Modulo: {{$item->modulo->name}}
                                                </p>
                                                <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                                    Profesor: {{$item->profesor->name}}
                                                </p>
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                            <a href="#" wire:click.prevent="muestragrupo({{$matricula->id}},{{1}})" class="inline-flex items-center font-medium text-green-600 dark:text-green-500 hover:underline">
                                                <i class="fa-solid fa-binoculars"></i>
                                            </a>
                                        </span>
                                    @endif

                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                @if ($matricula->status_est===4)
                                    <h2 class=" font-extrabold">
                                        FINALIZÓ EL CURSO - EGRESADO:
                                    </h2>
                                @endif
                                {{$matricula->alumno->name}} -- {{$matricula->alumno->documento}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($matricula->valor, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$matricula->metodo}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$matricula->creador->name}}
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
                    {{ $matriculas->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_creating)
        <livewire:academico.matricula.matriculas-crear :ruta="$ruta"/>
    @endif

    @if ($is_editing)
        <livewire:academico.matricula.matriculas-anular :elegido="$elegido" />
    @endif

    @if ($is_deleting)
        <livewire:academico.matricula.matriculas-grupo :elegido="$elegido" />
    @endif

    @if ($is_grupos)
        <livewire:academico.matricula.matriculas-asigna :elegido="$elegido" />
    @endif

    @if ($is_change)
        {{-- <livewire:academico.grupo.grupos-cambiar :elegido="$elegido" /> --}}
        <livewire:academico.ciclo.ciclos-cambiar :elegido="$elegido" />

    @endif

    @if ($is_document)
        <livewire:academico.matricula.documentos :elegido="$elegido" />
    @endif

    @if ($is_especiales)
        <livewire:academico.estudiante.caso-esp-matr />
    @endif

    @if ($is_activar)
        <livewire:academico.gestion.activar :estud="$elegido" />
    @endif

    @if ($is_comerciales)
        <livewire:academico.matricula.comerciales :elegido="$elegido" />
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
