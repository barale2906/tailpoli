<div>

    @if ($todo)
        @if ($transaccion)
            <h2 class="text-center text-2xl uppercase font-extrabold">
                Debe generar un movimiento por $ {{number_format($transaccion->inventario, 0, '.', ' ')}} para {{$transaccion->user->name}}
            </h2>
        @endif
        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
            @if ($transaccion)
                Sálida
            @else
                <div class="mb-6">
                    <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Tipo de movimiento</label>
                    <select wire:model.live="tipo" id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                        <option >Seleccione...</option>
                        <option value=1>Entrada</option>
                        <option value=0>Sálida</option>
                        <option value=2>Pendientes</option>
                        <option value=3>Traslado</option>
                        @can('in_productoCrear')
                            <option value=4>Dar de baja</option>
                        @endcan
                    </select>
                    @error('tipo')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif


            <div class="mb-6">
                <label for="sede_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja la sede</label>
                <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                    <option >Elija sede...</option>
                    @foreach ($sedes as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('sede_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            @if ($sede_id>0 && $crtAlma)
                <div class="mb-6">
                    <label for="almacen_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja almacén</label>
                    <select wire:model.live="almacen_id" id="almacen_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                        <option >Elija almacén...</option>
                        @foreach ($sede->almacenes as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('almacen_id')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif
        </div>
    @endif



        @if ($almacen_id>0 && !$transaccion)
            @switch($tipo)
                @case(1)
                    <livewire:inventario.inventario.entrada :almacen_id="$almacen_id" />
                    @break
                @case(0)
                    @if ($is_dia)
                        <livewire:inventario.inventario.salida :almacen_id="$almacen_id" :sede_id="$sede_id" :ruta="$ruta" />
                    @else
                        @include('includes.cajaCerrada')
                    @endif
                    @break
                @case(2)
                    <livewire:inventario.inventario.pendiente :almacen_id="$almacen_id" :sede_id="$sede_id" :ruta="$ruta" />
                    @break

                @case(3)
                    <livewire:inventario.traslado.envia :almacen_id="$almacen_id" :sede_id="$sede_id" :ruta="$ruta" />
                    @break

                @case(4)
                    <livewire:inventario.inventario.baja :almacen_id="$almacen_id"  />
                    @break

            @endswitch
        @endif

        @if ($transaccion && $almacen_id>0)
            <livewire:inventario.inventario.salida :almacen_id="$almacen_id" :sede_id="$sede_id" :ruta="$ruta" :transaccion="$transaccion->id"/>
        @endif



</div>
