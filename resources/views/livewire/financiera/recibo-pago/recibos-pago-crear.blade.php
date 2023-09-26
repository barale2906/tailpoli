<div>
    <form wire:submit.prevent="new">

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-6">
                <select wire:model.blur="sede_id" id="medio" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
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
            <h5 class="text-center text-3xl m-8">Registrar pago para: <strong class="uppercase">{{$alumnoName}}</strong> con documento N°: <strong class="uppercase">{{$alumnodocumento}}</strong></h5>

            <div class="grid grid-cols-3 gap-2 mb-4">
                <div class="ring-2 bg-slate-50 col-span-2 p-4">

                    <div>
                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            Otros Conceptos
                        </h5>
                        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" >
                                        Valor pagado
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        Concepto de pago
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        <input type="text" id="valor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a pagar" wire:model.blur="valor">
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white  text-right">
                                        <select wire:model.blur="conceptos" wire:change="asigOtro()" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                            <option>Seleccione...</option>
                                            @foreach ($concePagos as $item)
                                                @if ($item->tipo==='otro')
                                                    <option value={{$item->id}}>{{$item->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="mb-6">
                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Tipo de Movimiento</h3>
                            <select wire:model.blur="radio" wire:change="deftipo()" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                <option value="0">De Cartera</option>
                                <option value="1">De Inventario</option>
                            </select>
                        </div>
                    </div>
                    @if ($inveCart)
                        <div>
                            <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                Generar Sálidas de Inventario.
                            </h5>
                            <livewire:inventario.inventario.inventarios-crear :tipon="0" />
                        </div>
                    @else
                        <div>
                            @if ($pendientes->count()>0)
                                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    Obligaciones de Cartera
                                </h5>
                                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                                                Fecha pago programada
                                            </th>
                                            <th scope="col" class="px-6 py-3" >
                                                Saldo <small class=" text-red-400">De esta deuda</small>
                                            </th>
                                            <th scope="col" class="px-6 py-3" >
                                                Valor pagado
                                            </th>
                                            <th scope="col" class="px-6 py-3" >
                                                Concepto de pago
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendientes as $pendiente)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                    {{$pendiente->fecha_pago}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                    $ {{number_format($pendiente->saldo, 0, '.', ' ')}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                    <input type="text" id="valor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor a pagar" wire:model.blur="valor">
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white  text-right">
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <div>
                                                            <select wire:model.blur="conceptos" wire:change="asignar({{$pendiente}})" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                                                @foreach ($concePagos as $item)
                                                                    @if ($item->tipo==="cartera")
                                                                        <option value={{$item->id}}>{{$item->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <button type="button"
                                                            class="text-white bg-cyan-500 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto text-center p-2 dark:bg-cyan-400 dark:hover:bg-cyan-500 dark:focus:ring-cyan-400"
                                                            wire:click.prevent="asignar({{$pendiente}})"
                                                            >
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                    No Tiene Obligaciones de Cartera Registradas
                                </h5>
                            @endif
                        </div>
                    @endif



                </div>
                <div class="ring-2 bg-gray-50 p-4">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                        Total: $ {{number_format($Total, 0, '.', ' ')}}
                    </h5>

                    @if (count($detalles)>0)
                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            Obligaciones de Cartera
                        </h5>
                        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" >
                                        Concepto de pago
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        Saldo <small class=" text-red-400">De esta deuda</small>
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        Valor pagado
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalles as $detalle)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$detalle['concepto']}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                            $ {{number_format($detalle['saldo'], 0, '.', ' ')}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            $ {{number_format($detalle['valor'], 0, '.', ' ')}}
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
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
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                {{$otros->concepto}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                $ {{number_format($otros->valor, 0, '.', ' ')}}
                                            </th>
                                            <th>
                                                <a href="#" wire:click.prevent="elimOtro({{$otros->id}}, {{$otros->valor}})"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            Movimientos de Inventario
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
                                    @if ($otros->tipo==='inventario')
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                {{$otros->concepto}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                                $ {{number_format($otros->valor, 0, '.', ' ')}}
                                            </th>
                                            <th>
                                                <a href="#" wire:click.prevent="elimOtro({{$otros->id}}, {{$otros->valor}})"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
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
            <div class="mb-6">
                <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                <input type="text" id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Observaciones del recibo" wire:model.blur="observaciones">
            </div>
            @error('observaciones')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror

            @if ($Total>0)
                <button type="submit"
                class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                >
                    Nuevo Recibo
                </button>
            @endif
        @endif
        <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
