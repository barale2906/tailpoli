<div>
    <h1 class=" text-center text-xl">
        A continuación se presenta el menú de ayuda para el modulo <span class=" font-extrabold uppercase">{{$crt}}</span>
    </h1>
    @if ($is_video)

        <div class="grid sm:grid-cols-1 md:grid-cols-2 mb-2">

            <video class="w-full rounded-3xl" autoplay controls>
                <source src="{{$ruta}}" type="video/mp4">
                Tu navegador no soporta el video.
            </video>


            <div class="w-full rounded-xl p-4 text-center bg-white border border-gray-200 shadow-2xl sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white uppercase">
                    {{$seleccionado->titulo}}
                </h5>
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                    {{$seleccionado->descripcion}}
                </p>
                <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                    <a href="" wire:click.prevent="volver" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                        <i class="fa-solid fa-backward-fast fa-beat"></i>
                        <div class="text-left rtl:text-right ml-2">
                            <div class="mb-1 text-xs">
                                Seguir capacitandote
                            </div>
                            <div class="-mt-1 font-sans text-sm font-semibold">
                                Ver temas
                            </div>
                        </div>
                    </a>
                    <a href="{{$seleccionado->youtube}}" target="_blank" class="w-full sm:w-auto bg-red-800 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-red-700 dark:hover:bg-red-600 dark:focus:ring-red-700">
                        <i class="fa-brands fa-youtube"></i>
                        <div class="text-left rtl:text-right ml-2">
                            <div class="mb-1 text-xs">
                                Si lo prefieres
                            </div>
                            <div class="-mt-1 font-sans text-sm font-semibold">
                                Ver video en youtube
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    @else
        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4">
            @foreach ($modulos as $item)
                <a href="" wire:click.prevent="ver({{$item->id}})" class="block max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-sm text-center tracking-tight text-gray-900 dark:text-white uppercase font-extrabold">
                        {{$item->titulo}}
                    </h5>
                    <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                        DESCRIPCIÓN: <br>{{$item->descripcion}}
                    </p>
                </a>
            @endforeach
        </div>
    @endif


</div>
