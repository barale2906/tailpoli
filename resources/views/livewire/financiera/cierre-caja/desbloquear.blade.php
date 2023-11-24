<div>
    <h1 class="text-center text-lg font-semibold">
        Desde esta pantalla podrá desbloquear un usuario para poder generar nuevos recibos de caja y su respectivo cierre.
    </h1>
    <h1 class="text-center text-xl text-red-300 font-extrabold uppercase">
        ¡Hágalo solamente si es estrictamente necesario!
    </h1>
    <div class="mb-6">
        <select wire:model.live="cierre" id="cierre" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
            <option >Elija cierre - cajero...</option>
            @foreach ($cierres as $item)
                <option value={{$item->id}}>{{$item->cajero->name}} - {{$item->fecha_cierre}}</option>
            @endforeach
        </select>
    </div>
    @if ($cierre)

        <a href="" wire:click.prevent="desbloq" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
            Desbloquear
        </a>

    @endif

</div>
