<div>

    @if ($is_dia)
        @if ($is_transac)
            <h1 class="text-xl text-center uppercase">
                Cargar soporte de pago
            </h1>
            <livewire:financiera.transaccion.transaccion-crear :elegido="$alumno_id" />
        @endif

        @if ($is_recibo)
            <h1 class="text-xl text-center uppercase">Crear recibos de pago</h1>
            <form wire:submit.prevent="new">

                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-6">
                        <select wire:model.blur="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elija sede...</option>
                            @foreach ($sedes as $item)
                                <option value={{$item->id}}>{{$item->name}} - {{$item->sector->name}}</option>
                            @endforeach
                        </select>
                        @error('sede_id')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <div class="w-full">
                            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar Alumno</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input
                                    type="search"
                                    id="buscar"
                                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="digite nombre o documento del estudiante"
                                    wire:model="buscar"
                                    wire:keydown="buscAlumno()"
                                    autocomplete="off"
                                    >
                                <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600" wire:click="limpiar()">
                                    Limpiar Filtro
                                </button>
                            </div>
                        </div>
                        @if ($buscar)
                            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                @foreach ($estudiantes as $item)
                                    <li class="w-full mt-2 mb-2 capitalize">
                                        {{$item->name}} - {{$item->documento}} <a href="#" wire:click.prevent="selAlumno({{$item}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                                            <i class="fa-solid fa-check fa-beat"></i> elegir
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                @if ($alumno_id>0 && $sede_id>0)
                    <h5 class="text-center text-3xl m-8">
                        Registrar pago para: <strong class="uppercase">{{$alumnoName}}</strong> con documento N°: <strong class="uppercase">{{$alumnodocumento}}</strong>
                    </h5>
                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-2 mb-4">
                        <div>
                            @if ($alumno_id)
                                @if ($estuActual->transUser)
                                    @can('fi_transaccionesCrear')
                                        @php
                                            $conteo=0;
                                            foreach ($estuActual->transUser as $value) {
                                                if($value->status>1 && $value->status<4){
                                                    $conteo=$conteo+1;
                                                }
                                            }
                                        @endphp
                                        <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-red-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            @if ($conteo>0)
                                                <a href="" wire:click.prevent="generaInventario()" class="inline-flex items-center font-medium text-red-600 dark:text-cyan-500 hover:underline">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> Entrega inventario
                                                </a>
                                            @endif
                                        </button>
                                    @endcan
                                @endif

                                <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-cyan-100 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                    @can('fi_transaccionesCrear')
                                        <a href="#" wire:click.prevent="generatransaccion()" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                            <i class="fa-solid fa-camera"></i> Cargar Soporte
                                        </a>
                                    @endcan
                                </button>
                            @endif
                        </div>
                        @if (!$pagoTotal && $totalCartera>0)
                            <div class="mb-6">
                                <label for="pagoTotal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Pago Total: $ {{number_format($totalCartera, 0, '.', ' ')}}
                                </label>
                                <select wire:model.live="pagoTotal" id="pagoTotal" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                    <option value=true>Si</option>
                                    <option value=false>No</option>
                                </select>
                            </div>
                        @else
                            <div>
                                <h3 class="text-center text-2xl capitalize text-green-700">
                                    Se generará un recibo por: <strong>$ {{number_format($totalCartera, 0, '.', ' ')}}</strong>
                                </h3>
                            </div>
                            <input type="text" id="descuento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Aplicar descuento" wire:model.blur="descuento">
                        @endif
                    </div>
                    @if (!$pagoTotal)
                        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-2 mb-4">
                            <div class="ring-2 bg-slate-50 col-span-2 p-4">

                                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 uppercase text-xl font-semibold" colspan="3">
                                                Registrar pago por otros conceptos
                                            </th>
                                            <th scope="col" class="px-6 py-3 capitalize text-lg font-semibold" colspan="2">
                                                Descuento aplicable:
                                                @foreach ($vigentedescuento as $item)
                                                    @if ($item->aplica===2)
                                                        @if ($item->tipo===1)
                                                            {{$item->name}}: {{$item->valor}} %
                                                        @else
                                                            {{$item->name}}: $ {{number_format($item->valor, 0, ',', '.')}}
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="px-6 py-3" >
                                                Elija pago
                                            </th>
                                            <th scope="col" colspan="2" class="px-6 py-3" >
                                                <input type="text" id="otro" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a pagar" wire:model.live="otro">
                                            </th>{{--
                                            <th scope="col" colspan="2" class="px-6 py-3" >
                                                <input type="text" id="descuento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a descontar" wire:model.blur="descuento">
                                            </th> --}}
                                            <th scope="row" colspan="2" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white  text-right">
                                                @if ($otro)
                                                    <select wire:model.live="concepotro" wire:change="cargaOtro" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                                        <option>Seleccione...</option>
                                                        @foreach ($concePagos as $item)
                                                            @if ($item->tipo==="otro")
                                                                <option value={{$item->id}}>{{$item->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </th>
                                        </tr>
                                    </thead>
                                </table>

                                <div>
                                    @if ($totalCartera)

                                        <h4 class="mb-2 mt-2 text-center text-lg capitalize font-semibold tracking-tight text-gray-900 dark:text-white">
                                            Descuento aplicable:
                                                @foreach ($vigentedescuento as $item)
                                                    @if ($item->aplica===0)
                                                        @if ($item->tipo===1)
                                                            {{$item->name}}: {{$item->valor}} %
                                                        @else
                                                            {{$item->name}}: $ {{number_format($item->valor, 0, ',', '.')}}
                                                        @endif
                                                    @endif
                                                @endforeach
                                        </h4>
                                        <h5 class="mb-2 mt-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            Obligaciones de Cartera
                                        </h5>
                                        <h4 class="mb-2 mt-2 text-center text-lg capitalize font-semibold tracking-tight text-gray-900 dark:text-white">
                                            Seleccione la matricula a pagar.
                                        </h4>
                                        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-2 mb-4">
                                            @if ($matriculas)
                                                @foreach ($matriculas as $item)
                                                    <a href="" wire:click.prevent="matrielegida({{$item->matricula_id}})" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                            $ {{number_format($item->total_saldo, 0, '.', ' ')}}
                                                        </h5>
                                                        <p class="font-normal text-gray-700 dark:text-gray-400 capitalize">
                                                            {{$item->matricula->curso->name}}
                                                        </p>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>

                                        @if ($matricula_id>0)
                                            @if ($pendientes && $pendientes->sum('saldo')>0)
                                                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2 bg-red-100">
                                                    <h4 class="mb-2 mt-2 text-center text-lg capitalize font-semibold tracking-tight text-gray-900 dark:text-white">
                                                        Saldo en mora: $ {{number_format($pendientes->sum('saldo'), 0, '.', ' ')}}
                                                    </h4>
                                                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                                                                    Fecha pago programada
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    <span class=" text-xs">Curso</span>
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Saldo <small class=" text-red-400">De esta deuda</small>
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Concepto de pago
                                                                </th>{{--
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Valor pagado
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Registrar Descuento
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" ></th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($pendientes as $pendiente)
                                                                @php
                                                                    $cuota=explode("-----",$pendiente->observaciones);
                                                                    $cuo=$cuota[0];
                                                                @endphp
                                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                                        {{$pendiente->fecha_pago}}
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 text-sm text-gray-900 dark:text-white text-justify">
                                                                        {{$pendiente->matricula->curso->name}}
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                                        $ {{number_format($pendiente->saldo, 0, '.', ' ')}}
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 text-sm text-justify  text-gray-900 dark:text-white capitalize">
                                                                        {{$cuo}} - {{$pendiente->concepto}}
                                                                    </th>{{--
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                                                        <input type="text" id="valor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a pagar" wire:model.blur="valor">
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                                                        <input type="text" id="descuento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a descontar" wire:model.blur="descuento">
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white  text-right">
                                                                        <select wire:model.blur="conceptos" wire:change="asigOtro(1, {{$pendiente}})" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                                                            <option>Seleccione...</option>
                                                                            @foreach ($concePagos as $item)
                                                                                @if ($item->id===$pendiente->concepto_pago_id)
                                                                                    <option value={{$item->id}}>{{$item->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </th> --}}
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>
                                            @endif

                                            @if ($futuros && $futuros->sum('saldo')>0)
                                                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2 bg-green-100">
                                                    <h4 class="mb-2 mt-2 text-center text-lg capitalize font-semibold tracking-tight text-gray-900 dark:text-white">
                                                        Saldo total del convenio: $ {{number_format($futuros->sum('saldo'), 0, '.', ' ')}}
                                                    </h4>
                                                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                                                                    Fecha pago programada
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    <span class=" text-xs">Curso</span>
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Saldo <small class=" text-red-400">De esta deuda</small>
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Concepto de pago
                                                                </th>{{--
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Valor pagado
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" >
                                                                    Registrar Descuento
                                                                </th>
                                                                <th scope="col" class="px-6 py-3" ></th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                    $cuota=explode("-----",$siguientecuota->observaciones);
                                                                    $cuo=$cuota[0];
                                                                @endphp
                                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                                        {{$siguientecuota->fecha_pago}}
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 text-sm text-gray-900 dark:text-white text-justify">
                                                                        {{$siguientecuota->matricula->curso->name}}
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                                        $ {{number_format($siguientecuota->saldo, 0, '.', ' ')}}
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 text-sm text-justify  text-gray-900 dark:text-white capitalize">
                                                                        {{$cuo}} - {{$siguientecuota->concepto}}
                                                                    </th>{{--
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                                                        <input type="text" id="valor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a pagar" wire:model.blur="valor">
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                                                        <input type="text" id="descuento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a descontar" wire:model.blur="descuento">
                                                                    </th>
                                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white  text-right">
                                                                        <select wire:model.blur="conceptos" wire:change="asigOtro(1, {{$futuro}})" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                                                            <option>Seleccione...</option>
                                                                            @foreach ($concePagos as $item)
                                                                                @if ($item->id===$futuro->concepto_pago_id)
                                                                                    <option value={{$item->id}}>{{$item->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </th> --}}
                                                                </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                            <label for="filtrTransades" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                Registre el valor:
                                                @if ($pendientes && $pendientes->sum('saldo')>0)
                                                    <span class=" text-xs text-red-500">
                                                        Mínimo sugerido: $ {{number_format($pendientes->sum('saldo'), 0, '.', ' ')}}
                                                    </span>
                                                @endif
                                            </label>
                                            <div class="relative z-0 w-full mb-5 group">
                                                <input wire:model.live="pagado" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                                                <label for="pagado" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Valor a pagar</label>
                                            </div>
                                            <a href="" wire:click.prevent="cargaPago()"  class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                <i class="fa-solid fa-cash-register"></i>
                                            </a>

                                        @endif
                                    @else
                                        <h5 class="mb-2 mt-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            No Tiene Obligaciones de Cartera Registradas
                                        </h5>
                                    @endif
                                </div>
                            </div>
                            <div class="ring-2 bg-gray-50 p-4">
                                <h5 class="mb-2 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    Total a pagar: $ {{number_format($Total-$Totaldescue, 0, ',', '.')}}
                                </h5>
                                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    Total: $ {{number_format($Total, 0, ',', '.')}} -- Descuentos: $ {{number_format($Totaldescue, 0, ',', '.')}}
                                </h5>
                                @if ($cargados)
                                    <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        Otros Pagos
                                    </h5>
                                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3" >
                                                    Concepto de pago
                                                </th>
                                                <th scope="col" class="px-6 py-3" >
                                                    Valor pagado
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cargados as $otros)
                                                @if ($otros->tipo==='otro')
                                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                            {{$otros->concepto}}
                                                        </th>
                                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                            $ {{number_format($otros->valor, 0, '.', ' ')}}
                                                        </th>
                                                        <th>
                                                            <a href="" wire:click.prevent="elimOtro({{$otros->id}})"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                        Obligaciones de Cartera - Descuentos
                                    </h5>
                                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3" >
                                                    Concepto de pago
                                                </th>
                                                <th scope="col" class="px-6 py-3" >
                                                    Valor pagado
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cargados as $otros)
                                                @if ($otros->tipo==='cartera' || $otros->tipo==='financiero')
                                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                            {{$otros->concepto}}
                                                        </th>
                                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                            $ {{number_format($otros->valor, 0, '.', ' ')}}
                                                        </th>
                                                        <th>
                                                            <a href="#" wire:click.prevent="elimOtro({{$otros->id}})"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                        <div class="mb-6">
                            <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                            <input type="text" id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Observaciones del recibo" wire:model.blur="observaciones" autocomplete="off">

                            @error('observaciones')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>
                        @if ($Total>0)
                            @if (Auth::user()->rol_id===1)
                                <div class="mb-6">
                                    <label for="medio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Método de pago</label>
                                    <select wire:model.live="medio" id="medio" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                        <option >Elija...</option>
                                        <option value="PSE-1">PSE</option>
                                        <option value="transferencia-1">Transferencia</option>
                                        <option value="cheque-1">Cheque</option>
                                        <option value="efectivo-1">Efectivo</option>
                                        @foreach ($tarjetas as $item)
                                            <option value={{$item->id}}-2>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('medio')
                                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                        </div>
                                    @enderror
                                    @if ($recargo>0)
                                        <label for="medio" class="block mb-2 text-sm font-medium text-red-600 dark:text-white capitalize">
                                            Tendrá un recargo del <strong>{{$recargo}} %</strong>
                                        </label>
                                    @endif
                                </div>
                            @else
                                <div class="mb-6">
                                    <label for="medio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Método de pago</label>
                                    <select wire:model.live="medio" id="medio" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                        <option >Elija...</option>
                                        @if ($ruta===4)
                                            <option value="PSE-1">PSE</option>
                                            <option value="transferencia-1">Transferencia</option>
                                            <option value="cheque-1">Cheque</option>
                                            <option value="efectivo-1">Efectivo</option>
                                            @foreach ($tarjetas as $item)
                                                <option value={{$item->id}}-2>{{$item->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="efectivo-1">Efectivo</option>
                                            @foreach ($tarjetas as $item)
                                                <option value={{$item->id}}-2>{{$item->name}}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @error('medio')
                                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                        </div>
                                    @enderror
                                    @if ($recargo>0)
                                        <label for="medio" class="block mb-2 text-sm font-medium text-red-600 dark:text-white capitalize">
                                            Tendrá un recargo del <strong>{{$recargo}} %</strong>
                                        </label>
                                    @endif
                                </div>
                            @endif
                        @endif


                    </div>
                    @if ($Total>0 || $pagoTotal)
                        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                            <div id="alert-additional-content-2" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <h3 class="text-lg font-medium">¡IMPORTANTE!</h3>
                                </div>
                                <div class="mt-2 mb-4 text-sm uppercase">
                                    <p>
                                        Asegurese de recibir el pago antes de generar el recibo.
                                    </p>
                                </div>
                                <div class="flex">

                                    <button type="submit"
                                    class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                                    >
                                        Nuevo Recibo
                                    </button>

                                    <div wire:loading class=" text-2xl text-red-700 font-extrabold uppercase">
                                        Espere generando Recibo...
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                @endif
                <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </form>
        @endif

        @if ($is_inventa)
            <h1 class="text-xl text-center uppercase">
                Generar entrega
            </h1>
            <livewire:financiera.transaccion.transaccion-gestion :elegido="$alumno_id" :ruta="2" />
        @endif



    @else
        @include('includes.cajaCerrada')
    @endif

</div>