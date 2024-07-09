<div>
    $$$ {{$valor_total}}<br>
    @foreach ($reciboselegidos as $item)
        {{$item->numero_recibo}}-- {{$item->valor_total}} -- {{$item->id}}<br>
    @endforeach

    @foreach ($totalmedios as $item)
        {{$item->medio}} -- {{$item->total}}
    @endforeach

    <button type="button" wire:click.prevent="creaciprerre" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Default</button>

</div>
