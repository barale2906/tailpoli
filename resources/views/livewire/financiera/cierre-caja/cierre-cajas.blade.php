<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">cierres de caja</h1>
    </div>

    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">
            @include('includes.filtro')
            @if ($is_reporte)
                @can('fi_cierrecajaCrear')
                    <a href="#" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-plus"></i> crear
                    </a>
                @endcan
                @can('fi_activarecibos')
                    <a href="#" wire:click.prevent="$dispatch('desbloqueando')" class="w-auto text-black bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-unlock-keyhole"></i> Desbloquear
                    </a>
                @endcan
                @can('fi_export')
                    <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-file-excel fa-beat"></i>
                    </a>
                @endcan
            @else
                @can('fi_export')
                    <a href="#" wire:click.prevent="empresa" class="w-auto text-cyan-800 bg-gradient-to-r from-cyan-400 via-teal-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-building"></i> @if ($is_poliandino)
                            Poliandino
                        @else
                            Polidotaciones
                        @endif
                    </a>
                    <a href="#" wire:click.prevent="exportcontab" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-file-excel fa-beat"></i>
                    </a>
                @endcan
            @endif
        </div>
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;">
                            Coordinador
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;">
                            Cajero
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_cierre')">
                            Fecha
                            @if ($ordena != 'fecha_cierre')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor_total')">
                            Total
                            @if ($ordena != 'valor_total')
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
                            Observaciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cierres as $cierre)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    @if (!$cierre->status)
                                        @can('fi_cierrecajaAprobar')
                                            <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-blue-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                                <a href="" wire:click.prevent="show({{$cierre}},{{0}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                    <i class="fa-solid fa-check-double"></i>
                                                </a>
                                            </button>
                                        @endcan
                                    @endif
                                    <a href="" wire:click.prevent="show({{$cierre}},{{1}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                        <button type="button" class="inline-flex rounded-e-lg items-center p-2 text-sm font-medium text-gray-900 bg-orange-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            <i class="fa-solid fa-binoculars"></i>
                                        </button>
                                    </a>
                                </div>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$cierre->id}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$cierre->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$cierre->coorcaja->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$cierre->cajero->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$cierre->fecha_cierre}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize text-right">
                                $ {{number_format($cierre->valor_total, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-right">
                                {{$cierre->observaciones}}
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
                    {{ $cierres->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_creating)
        <livewire:financiera.cierre-caja.cierre-cajas-crear />
    @endif

    @if ($is_deleting)
        <livewire:financiera.cierre-caja.cierre-cajas-imprimir :elegido="$elegido" :accion="$accion"/>
    @endif

    @if ($is_watching)
        <livewire:financiera.cierre-caja.cierre-cajas-imprimir :elegido="$elegido" :accion="$accion"/>
    @endif

    @if ($is_desbloqueo)
        <livewire:financiera.cierre-caja.desbloquear/>
    @endif

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
