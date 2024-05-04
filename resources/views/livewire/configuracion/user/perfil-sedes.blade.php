<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
        <div class="sm:grid-cols-1 md:col-span-2">
            <h3 class="text-lg font-medium text-center">Sedes asignadas a: <span class=" uppercase">{{$actual->name}}</span></h3>
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
            @if (count($noperte))
                @foreach ($noperte as $item)
                    <a href="" wire:click.prevent="sel({{$item->id}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-regular fa-circle-check fa-beat-fade"></i> {{$item->name}}
                    </a>
                @endforeach
            @else
                <h3 class="text-md font-medium text-center col-span-3 capitalize">Está asignado(a) a todas las sedes.</h3>
            @endif
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
            @if ($this->actual->sedes->count())
                @foreach ($this->actual->sedes as $item)
                    <a href="" wire:click.prevent="elim({{$item->id}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-trash-can fa-bounce"></i> {{$item->name}}
                    </a>
                @endforeach
            @else
                <h3 class="text-md font-medium text-center col-span-3 capitalize">No tiene sedes asignadas.</h3>
            @endif
        </div>
    </div>
</div>
