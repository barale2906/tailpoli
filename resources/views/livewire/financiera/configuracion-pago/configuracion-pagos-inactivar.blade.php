<div>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 " role="alert">
        <span class="font-medium">¡IMPORTANTE!</span> ¿Está seguro(a) de cambiar el estado de <strong class="uppercase text-3xl"><h1>{{$descripcion}}</h1></strong><p>Su estado actual es: </p><h4 class="uppercase text-2xl">{{$status===true ? "ACTIVO" : "INACTIVO"}}</h4>.
    </div>
    <a href="#" wire:click.prevent="inactivar()" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
        <i class="fa-brands fa-creative-commons-sa"></i> Cambiar Estado
    </a>
    <a href="#" wire:click.prevent="$dispatch('Inactivando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
        <i class="fa-solid fa-rectangle-xmark"></i> cancelar
    </a>
</div>
