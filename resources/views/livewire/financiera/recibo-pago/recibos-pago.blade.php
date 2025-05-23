<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">recibos de pago</h1>
    </div>

    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">
            @include('includes.filtro')
            @if ($is_reporte)
                @can('fi_recibopagoCrear')
                    <a href="#" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                        <i class="fa-solid fa-plus"></i> Ingreso
                    </a>
                @endcan
            @endif

            @can('fi_export')
                <a href="#" wire:click.prevent="empresa" class="w-auto text-cyan-800 bg-gradient-to-r from-cyan-400 via-teal-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-building"></i>
                </a>
                <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-file-excel fa-beat"></i>
                </a>
            @endcan
        </div>
        @if (!$is_filtro)
            @can('fi_recibopagoAnular')
                <h1>
                    <span class=" font-extrabold">VALOR TOTAL</span> según el filtro aplicado: <span class=" font-extrabold">$ {{number_format($recibosTotal->total_valor_total, 0, '.', ' ')}}</span>, <span class=" font-extrabold">VALOR DESCUENTOS</span> según el filtro: <span class=" font-extrabold">$ {{number_format($recibosTotal->total_descuento, 0, '.', ' ')}}</span>, <span class=" font-extrabold">VALOR NETO: $ {{number_format($recibosTotal->total_valor_total-$recibosTotal->total_descuento, 0, '.', ' ')}}</span>
                </h1>
            @endcan
        @endif


        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('id')">
                            No
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha')">
                            Fecha Recibo
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_transaccion')">
                            Fecha Transacción
                            @if ($ordena != 'fecha_transaccion')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor_total')">
                            Valor
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('descuento')">
                            Descuento
                            @if ($ordena != 'descuento')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Detalles del recibo
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('medio')">
                            Medio
                            @if ($ordena != 'medio')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Creador
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('observaciones')">
                            Observaciones
                            @if ($ordena != 'observaciones')
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
                    @foreach ($recibos as $recibo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($recibo->status===0)
                                    @can('fi_recibopagoAnular')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                            <a href="#" wire:click.prevent="show({{$recibo}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i> - {{$recibo->numero_recibo}}
                                            </a>
                                        </span>
                                    @endcan
                                @else
                                    @if ($recibo->status!=2 && Auth::user()->rol_id===1)
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                            <a href="#" wire:click.prevent="show({{$recibo}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i> - {{$recibo->numero_recibo}}
                                            </a>
                                        </span>
                                    @else
                                        {{$recibo->numero_recibo}}
                                    @endif
                                @endif
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    <a href="/impresiones/imprecibo?rut=0&r={{$recibo->id}}" class="inline-flex items-center font-medium text-blue-600 dark:texgreen-500 hover:underline">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </span>
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    <a href="#" wire:click.prevent="show({{$recibo}},{{2}})" class="inline-flex items-center font-medium text-green-600 dark:texgreen-500 hover:underline">
                                        <i class="fa-solid fa-binoculars"></i>
                                    </a>
                                </span>

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$recibo->fecha}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$recibo->fecha_transaccion}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$recibo->paga->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$recibo->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                $ {{number_format($recibo->valor_total, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                $ {{number_format($recibo->descuento, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">

                                <table class=" text-xs text-left text-gray-500 dark:text-gray-400 border border-collapse">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th>
                                                Concepto
                                            </th>
                                            <th>
                                                Producto
                                            </th>
                                            <th>
                                                Cantidad
                                            </th>
                                            <th>
                                                Valor
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recibo->conceptos as $item)
                                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700 hover:bg-cyan-200 text-sm">
                                                <td>
                                                    {{$item->name}}
                                                </td>
                                                <td>
                                                    {{$item->pivot->producto}}
                                                </td>
                                                <td class=" text-center">
                                                    {{$item->pivot->cantidad}}
                                                </td>
                                                <td class=" text-right">
                                                    $ {{number_format($item->pivot->valor, 0, ',', '.')}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white  text-right">
                                {{$recibo->medio}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$recibo->creador->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$recibo->observaciones}}
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
                            <option value=3>3</option>
                            <option value=15>15</option>
                            <option value=20>20</option>
                            <option value=50>50</option>
                            <option value=100>100</option>
                        </select>
                    </label>
                </div>
                <div>
                    {{ $recibos->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_creating)
        <livewire:financiera.recibo-pago.recibos-pago-crear :ruta="0" />
    @endif

    @if ($is_editing)
        <livewire:financiera.recibo-pago.recibos-pago-anular :elegido="$elegido" :accion="$accion" />
    @endif

    @if ($is_deleting)
        <livewire:financiera.recibo-pago.recibos-pago-consultar :elegido="$elegido" />
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
