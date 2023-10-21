<div>

    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        <div class="mb-6">
            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Tipo de movimiento</label>
            <select wire:model.live="tipo" id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Seleccione...</option>
                <option value=1>Entrada</option>
                <option value=0>sálida</option>
            </select>
            @error('tipo')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="sede_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja la sede</label>
            <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
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

        @if ($sede_id>0)
            <div class="mb-6">
                <label for="almacen_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja almacén</label>
                <select wire:model.live="almacen_id" id="almacen_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
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

    @if ($almacen_id>0)

        @if ($tipo==="1")

            <livewire:inventario.inventario.entrada :almacen_id="$almacen_id" />

        @endif
        @if ($tipo==="0")
            inactivas!!!!
            <div class="mb-6">
                <label for="medio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Método de pago</label>
                <select wire:model.blur="medio" id="medio" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija...</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="PSE">PSE</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="tarjeta credito">Tarjeta Crédito</option>
                    <option value="tarjeta debito">Tarjeta débito</option>
                    <option value="cheque">Cheque</option>
                </select>
                @error('medio')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif



    @endif


</div>
