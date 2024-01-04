<div>
    <h1 class="t text-center text-lg font-bold mb-2">
        Esta seguro(a) de reutilizar la programación: <strong>{{$actual->name}}</strong>
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4">

        <div>
            <a href="" wire:click.prevent="reutilizar()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> Reutilizar
            </a>
        </div>
        <div>
            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
    </div>
</div>
