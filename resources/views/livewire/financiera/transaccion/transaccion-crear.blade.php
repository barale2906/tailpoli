<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4">
        <div class="mb-6">
            <label for="sede_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">sede donde registra el soporte</label>
            <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
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
        @if ($sede_id)
            <div class="mb-6">
                <label for="total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor total del registro</label>
                <input  id="total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor total de la consignación, transferencia" wire:model="total" required>
                @error('total')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif

        <div class="mb-6">
            <label for="fecha_transaccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de la transacción</label>
            <input  id="fecha_transaccion" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model="fecha_transaccion" required>
            @error('fecha_transaccion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="banco" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Banco donde consignaron</label>
            <select wire:model.live="banco" id="banco" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija banco...</option>
                <option value='Bancolombia Ahorros'>Bancolombia Ahorros</option>
                <option value='Colpatria Ahorros'>Colpatria Ahorros</option>
                <option value='Davivienda Ahorros'>Davivienda Ahorros</option>
                <option value='Davivienda Corriente'>Davivienda Corriente</option>
            </select>
            @error('banco')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        @if (!$editarlo)
            <div class="mb-6">
                <label for="opcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Concepto que paga</label>
                <select wire:model.live="opcion" id="opcion" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option >Elija opción...</option>
                    <option value=1>Acádemico</option>
                    <option value=2>Otros</option>
                    <option value=3>Acádemico - Otros</option>
                </select>
            </div>
        @endif

        @if ($is_academico )
            <div class="mb-6">
                <label for="academico" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor del pago por acádemico</label>
                <input  id="academico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor concepto acádemico" wire:model="academico" required>
                @error('academico')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif

        @if ($is_otro)
            <div class="mb-6">
                <label for="otro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor del pago por otros</label>
                <input  id="otro" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor concepto otros" wire:model="otro" required>
                @error('otro')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif
        @if ($is_academico || $is_otro)
            @if (!$editarlo)
                <div class="mb-6">
                    <label for="soporte" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elija el archivo a enviar</label>
                    <input type="file"  id="soporte" accept="image/jpg, image/bmp, image/png, image/jpeg, .pdf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Foto del soporte" wire:model="soporte">
                    @error('soporte')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                    <div wire:loading wire:target="soporte" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
                </div>
            @endif
        @endif

    </div>
    <div class="mb-6">
        <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre Observaciones</label>
        <textarea id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Describa el objetivo de la transacción" wire:model.live="observaciones">

        </textarea>
        @error('observaciones')
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
            </div>
        @enderror
        @if ($editarlo)
            <p class=" text-justify">
                Observaciones registradas: {{$editarlo->observaciones}}
            </p>
        @endif
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 m">
        @if ($editarlo)
            <a href="" wire:click.prevent="editar" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Editar solicitud
            </a>
            <a href="" wire:click.prevent="anular" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-triangle-exclamation"></i> Anular solicitud
            </a>
            <a href="" wire:click.prevent="$dispatch('cambiando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        @else

            @if ($soporte)
                <a href="" wire:click.prevent="crear" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-upload"></i> Cargar Soporte
                </a>
            @endif

            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        @endif


        <div>
            <img class="h-auto max-w-full rounded-lg" src={{public_path($url)}} alt="{{$url}}">
        </div>
    </div>
</div>
