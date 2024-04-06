<div>
    <h1 class=" text-center text-xl">
        A continuación se presenta el menú de ayuda para el modulo <span class=" font-extrabold uppercase">{{$crt}}</span>
    </h1>
    @if ($is_video)

        <div class="grid sm:grid-cols-1 md:grid-cols-2 mb-2">

            <video class="w-full" autoplay controls>
                <source src="{{$ruta}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif
    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4">
        @foreach ($modulos as $item)
            <a href="" wire:click.prevent="ver({{$item->id}})" class="block max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                    {{$item->titulo}}
                </h5>
                <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                    Modulo: {{$item->descripcion}}
                </p>
            </a>
        @endforeach
    </div>

</div>
