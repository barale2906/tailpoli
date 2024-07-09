<div>
    @if (!$is_especiales)
        <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
            <h1 class="text-xl uppercase">Gestión diaria</h1>
        </div>
    @endif


    @if ($is_modify)
        @include('includes.filtro')
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">

            {{-- pantalla grande --}}
            <div class="hidden md:flex md:space-x-4 w-full">
                @can('ac_estudianteCrear')
                    <a href="" wire:click.prevent="$dispatch('estudiantes')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center ml-1 mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-graduation-cap"></i> Estudiante
                    </a>
                @endcan
                @can('ac_matriculaCrear')
                    <a href="" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-book-medical"></i> Matricula
                    </a>
                @endcan
                @can('ac_matriculaCrear')
                    <a href="" wire:click.prevent="$dispatch('especia')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-book-medical"></i> Casos Especiales
                    </a>
                @endcan
                @can('fi_recibopagoCrear')
                    <a href="" wire:click.prevent="$dispatch('Editando')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-file-invoice-dollar"></i> Recibo
                    </a>
                @endcan
                @can('fi_cierrecajaCrear')
                    <a href="" wire:click.prevent="$dispatch('Inactivando')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-receipt"></i> Cierre
                    </a>
                @endcan
                @can('ac_export')
                    {{-- <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg  text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-file-excel"></i> Descargar
                    </a> --}}
                @endcan
                @can('in_inventarioCrear')
                    <a href="" wire:click.prevent="$dispatch('inventario')" class="w-auto text-black bg-gradient-to-r from-white via-white to-white hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-white dark:focus:ring-white font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-check"></i>
                    </a>
                @endcan
            </div>

            {{-- pantalla pequeña --}}
            <div class="md:hidden w-full">
                @can('ac_estudianteCrear')
                    <a href="" wire:click.prevent="$dispatch('estudiantes')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center ml-1 mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-graduation-cap"></i>
                    </a>
                @endcan
                @can('ac_matriculaCrear')
                    <a href="" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-book-medical"></i>
                    </a>
                @endcan
                @can('ac_matriculaCrear')
                    <a href="" wire:click.prevent="$dispatch('especia')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-book-medical"></i>
                    </a>
                @endcan
                @can('fi_recibopagoCrear')
                    <a href="" wire:click.prevent="$dispatch('Editando')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </a>
                @endcan
                @can('fi_cierrecajaCrear')
                    <a href="" wire:click.prevent="$dispatch('Inactivando')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-receipt"></i>
                    </a>
                @endcan
                @can('ac_export')
                    {{-- <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg  text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-file-excel"></i> Descargar
                    </a> --}}
                @endcan
                @can('in_inventarioCrear')
                    <a href="" wire:click.prevent="$dispatch('inventario')" class="w-auto text-black bg-gradient-to-r from-white via-white to-white hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-white dark:focus:ring-white font-medium rounded-lg text-sm p-2 text-center mr-1 mb-2 capitalize" >
                        <i class="fa-solid fa-check"></i>
                    </a>
                @endcan
            </div>
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
                            Estudiante
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Programación
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Grupo(s)
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
                    @foreach ($controles as $controle)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-blue-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <a href="" wire:click.prevent="show({{$controle->matricula_id}},{{5}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <i class="fa-solid fa-book"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-orange-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        @can('ac_gestionCrear')
                                            <a href="" wire:click.prevent="show({{$controle->id}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i>
                                            </a>
                                        @endcan
                                    </button>


                                    @if ($controle->estudiante->transUser)
                                        @can('fi_transaccionesCrear')
                                            @php
                                                $conteo=0;
                                                foreach ($controle->estudiante->transUser as $value) {
                                                    if($value->status>1 && $value->status<4){
                                                        $conteo=$conteo+1;
                                                    }
                                                }
                                            @endphp
                                            <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-red-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                                @if ($conteo>0)
                                                    <a href="" wire:click.prevent="show({{$controle->estudiante_id}},{{4}})" class="inline-flex items-center font-medium text-red-600 dark:text-cyan-500 hover:underline">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                    </a>
                                                @endif
                                            </button>
                                        @endcan

                                    @endif

                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-cyan-100 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        @can('fi_transaccionesCrear')
                                            <a href="#" wire:click.prevent="show({{$controle->estudiante->id}},{{3}})" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                                <i class="fa-solid fa-camera"></i>
                                            </a>
                                        @endcan
                                    </button>
                                </div>

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$controle->inicia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$controle->estudiante->name}} -- {{number_format($controle->estudiante->documento, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$controle->ciclo->name}}
                            </th>
                            <th scope="row" class="font-medium text-gray-900 dark:text-white capitalize pt-3 pb-3">


                                    @if ($controle->inicia>$hoy)
                                        Inicia el {{$controle->inicia}}
                                    @else
                                        @if ($is_vergrupo && $crtid===$controle->id)
                                            <span class="bg-cyan-100 text-cyan-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-cyan-900 dark:text-cyan-300">
                                                <a href="#" wire:click.prevent="muestragrupo({{$controle->id}},{{2}})" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                                    <i class="fa-solid fa-eye-slash"></i>
                                                </a>
                                            </span>
                                            @foreach ($controle->ciclo->ciclogrupos as $item)
                                                <div class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                                    <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                                        {{$item->grupo->name}}
                                                    </h5>
                                                    <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                                        Modulo: {{$item->grupo->modulo->name}}
                                                    </p>
                                                    <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize mb-2">
                                                        Profesor: {{$item->grupo->profesor->name}}
                                                    </p>
                                                    <a href="" wire:click.prevent="notas({{$item->grupo->id}}, {{$controle->estudiante_id}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-9 capitalize">
                                                        <i class="fa-solid fa-magnifying-glass"></i> Notas
                                                    </a>

                                                    <a href="" wire:click.prevent="asistencia({{$controle->ciclo_id}}, {{$item->grupo->id}}, {{$controle->estudiante_id}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-5 capitalize">
                                                        <i class="fa-regular fa-calendar-days"></i> Asistencia
                                                    </a>
                                                </div>
                                                @if ($item->fecha_inicio<=$hoy && $item->fecha_fin>=$hoy)

                                                @endif
                                            @endforeach
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                <a href="#" wire:click.prevent="muestragrupo({{$controle->id}},{{1}})" class="inline-flex items-center font-medium text-green-600 dark:text-green-500 hover:underline">
                                                    <i class="fa-solid fa-binoculars"></i>
                                                </a>
                                            </span>
                                        @endif

                                    @endif

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$controle->ultimo_pago}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$controle->ultima_asistencia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($controle->mora, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$controle->overol}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @foreach ($estados as $item)
                                    @if ($item->id===$controle->status_est)
                                        {{$item->name}}
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
                    {{ $controles->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_creating)
        <livewire:academico.matricula.matriculas-crear :ruta="$ruta" />
    @endif

    @if ($is_editing)
        <livewire:financiera.recibo-pago.recibos-pago-crear :ruta="$ruta" />
    @endif

    @if ($is_deleting)
        {{-- <livewire:financiera.cierre-caja.cierre-cajero-crear :ruta="$ruta" /> --}}
        {{-- <livewire:financiera.cierre-caja.cierre-por-cajero :ruta="$ruta" /> --}}
        <livewire:financiera.cerrar-caja.cierra-jornada-cajero :ruta="$ruta"/>
    @endif

    @if ($is_grupos)
        <livewire:academico.matricula.matriculas-asigna :elegido="$elegido" />
    @endif

    @if ($is_change)
        <livewire:configuracion.user.users-create :clase="1" :perf="0" :ruta="$ruta"/>
    @endif

    @if ($is_inventario)
        <livewire:inventario.inventario.inventarios-create :ruta="$ruta"/>
    @endif

    @if ($is_observaciones)
        <livewire:academico.gestion.observaciones :elegido="$elegido" :ruta="$ruta"/>
    @endif

    @if ($is_notas)
        <livewire:academico.nota.notas-editar :elegido="$elegido"/>
    @endif

    @if ($is_asistencias)
        <livewire:academico.asistencia.asisgestion :ciclo="$ciclo" :elegido="$elegido" :estudiante_id="$estudiante_id"/>
    @endif

    @if ($is_transacciones)
        <livewire:financiera.transaccion.transaccion-crear :elegido="$elegido" />
    @endif

    @if ($is_gestransaccion)
        <livewire:financiera.transaccion.transaccion-gestion :elegido="$elegido" :ruta="$ruta" />
    @endif

    @if ($is_document)
        <livewire:academico.matricula.documentos :elegido="$elegido" />
    @endif

    @if ($is_especiales)
        <livewire:academico.estudiante.caso-esp-matr />
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
