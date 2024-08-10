<div>
    <h1 class=" text-center text-2xl font-extrabold">
        Bienvenido(a) al menú de ayuda de nuestro ERP
    </h1>
    <nav class="dark:bg-gray-700 rounded-lg">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 text-sm capitalize">
                    <li class="{{$videostate ? 'bg-blue-100': ''}} p-4 rounded-full">
                        <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline" aria-current="page">
                            Videos
                        </a>
                    </li>
                    <li class="{{$pdfstate ? 'bg-orange-100': ''}} p-4 rounded-full">
                        <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline">
                            Documentos PDF
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @if ($videostate)
        @if ($is_detalle)
            <div class=" bg-blue-50 rounded-lg p-3">
                <livewire:admin.ayuda.detalle :tipo="$tipo" :crt="$crt"/>
            </div>

        @else
            <div class="grid sm:grid-cols-1 md:grid-cols-6 justify-center gap-2 m-3 bg-blue-50 p-3 rounded-lg">
                <button type="button" wire:click.prevent="buscar(1,'academico')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-graduation-cap"></i>
                    ACÁDEMICO
                </button>

                {{-- <button type="button" wire:click.prevent="buscar(1,'clientes')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-satellite-dish"></i>
                    CLIENTES
                </button>

                <button type="button" wire:click.prevent="buscar(1,'cartera')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-cash-register"></i>
                    CARTERA
                </button> --}}

                <button type="button" wire:click.prevent="buscar(1,'financiera')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-chart-line"></i>
                    FINANCIERA
                </button>

                {{-- <button type="button" wire:click.prevent="buscar(1,'administracion')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-toolbox"></i>
                    ADMINISTRACIÓN
                </button>

                <button type="button" wire:click.prevent="buscar(1,'configuracion')" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    CONFIGURACION
                </button> --}}
            </div>
        @endif
    @endif

    @if ($pdfstate)
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-2 bg-orange-100 rounded-lg p-3">
            <div class="max-w-sm border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 bg-orange-100 p-3">
                <div class="h-full px-3 pb-4 overflow-y-auto bg-orange-50 dark:bg-gray-800">
                    <ul class="space-y-2 font-medium">
                        @foreach ($menus as $item)
                            <li>
                                @can($item->permiso)
                                    <button type="button" wire:click.prevent="buscar(2,{{$item->id}})" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group ">
                                        <i class="{{$item->icono}}"></i>
                                        <span class="ml-3">{{$item->name}}</span>
                                    </button>
                                @endcan
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @if ($is_pdf)
                <livewire:admin.ayuda.detalle :tipo="$tipo" :crt="$orid"/>
            @endif
        </div>
    @endif
</div>
