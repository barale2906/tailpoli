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
        <div class="mb-6">
            <label for="opcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Concepto que paga</label>
            <select wire:model.live="opcion" id="opcion" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option >Elija opción...</option>
                <option value=1>Acádemico</option>
                <option value=2>Inventario</option>
                <option value=3>Acádemico - inventario</option>
            </select>
        </div>
        @if ($is_academico)
            <div class="mb-6">
                <label for="academico" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor del pago por academico</label>
                <input  id="academico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor concepto acádemico" wire:model="academico" required>
            </div>
        @endif

        @if ($is_inventario)
            <div class="mb-6">
                <label for="inventario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor del pago por inventario</label>
                <input  id="inventario" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor concepto inventarios" wire:model="inventario" required>
            </div>
        @endif
        <div class="mb-6">
            <label for="soporte" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elija la imagen a enviar</label>
            <input type="file"  id="soporte" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Foto del soporte" wire:model="soporte">
            @error('soporte')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

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
    </div>
</div>
