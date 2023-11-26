<div>
    <div class="flex p-4 text-sm text-blue-800 rounded-lg bg-cyan-100 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-bold uppercase text-2xl ">Datos seleccionados para: {{$actual->producto->name}}.</span>
            <div class="grid grid-cols-3 gap-3 m-3">
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                        <li>Almacén: <strong>{{$actual->almacen->name}}</strong></li>
                        <li>Usuario que registro el movimiento: <strong>{{$actual->user->name}}</strong></li>
                    </ul>
                </div>
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg">
                        <li>Fecha de movimiento: <strong>{{$actual->fecha_movimiento}}</strong></li>
                        <li>Tipo de movimiento:
                            <strong>
                                @switch($actual->tipo)
                                    @case(0)
                                        SALIDA
                                        @break
                                    @case(1)
                                        ENTRADA
                                        @break
                                    @case(2)
                                        PENDIENTE
                                        @break
                                @endswitch
                            </strong>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg">
                        <li>Cantidad: <strong>{{$actual->cantidad}}</strong></li>
                        <li>Saldo: <strong>{{$actual->saldo}}</strong></li>
                        <li>Precio: <strong>{{number_format($actual->precio, 0, '.', ' ')}}</strong></li>
                    </ul>
                </div>
            </div>
            <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg">
                <li>Descripción: <strong>{{$actual->descripcion}}</strong></li>
            </ul>
            <a href="#" wire:click.prevent="$dispatch('Inactivando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
            </a>
        </div>
    </div>

    <nav class="dark:bg-gray-700 rounded-lg">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 text-sm capitalize">
                    <li class="{{$saldostate ? 'bg-green-100': ''}} p-4">
                        <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Saldo de este producto por Almacén</a>
                    </li>
                    <li class="{{$almacenstate ? 'bg-orange-100': ''}} p-4">
                        <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline">Movimientos por almacén de este producto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @if ($saldostate)
        <div class="{{$saldostate ? 'bg-green-100': ''}}">
            <h5 class="text-xl uppercase text-center ">saldos por almacén</h5>
            <dl class="grid max-w-screen-xl grid-cols-4 gap-3 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                @foreach ($saldos as $item)
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">{{$item->saldo}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">{{$item->almacen->name}}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    @endif
    @if ($almacenstate)
        <livewire:inventario.inventario.inventarios-sede :producto="$actual" />
    @endif



</div>
