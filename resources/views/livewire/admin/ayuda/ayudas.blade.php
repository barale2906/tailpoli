<div>
    <h1 class=" text-center text-2xl font-extrabold">
        Bienvenido(a) al menú de ayuda de nuestro ERP
    </h1>

    @if ($is_detalle)
        <livewire:admin.ayuda.detalle :crt="$crt" />
    @else
        <div class="grid sm:grid-cols-1 md:grid-cols-6 justify-center gap-2 m-3">
            <button type="button" wire:click.prevent="buscar('academico')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-graduation-cap"></i>
                ACÁDEMICO
            </button>

            {{-- <button type="button" wire:click.prevent="buscar('clientes')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-satellite-dish"></i>
                CLIENTES
            </button>

            <button type="button" wire:click.prevent="buscar('cartera')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-cash-register"></i>
                CARTERA
            </button> --}}

            <button type="button" wire:click.prevent="buscar('financiera')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-chart-line"></i>
                FINANCIERA
            </button>

            {{-- <button type="button" wire:click.prevent="buscar('administracion')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-toolbox"></i>
                ADMINISTRACIÓN
            </button>

            <button type="button" wire:click.prevent="buscar('configuracion')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                CONFIGURACION
            </button> --}}
        </div>
    @endif

</div>
