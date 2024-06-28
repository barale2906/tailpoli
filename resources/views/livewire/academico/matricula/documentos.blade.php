<div>
    <div class="text-center text-xl mb-3">
        A continuación podra ver y descargar los documentos generados para la matricula de <span class="font-extrabold uppercase">{{$matricula->alumno->name}}</span> con fecha de inicio: {{$matricula->fecha_inicia}}
        <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
        </a>.
    </div>
    <h1 class=" text-center font-semibold uppercase">
        Documentos asignados para firma
    </h1>
    <div class="content-center text-center">

        <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-1 m-1">
            @if ($is_carnet)

                <a wire:click.prevent="carnetgen()" class="block max-w-sm p-1 bg-teal-400 border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-xs md:text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                        Enviar Carnet
                    </h5>
                </a>
            @endif

            @foreach ($documentos as $item)
                <a href="{{$item['ruta']}}" target="_blank" class="block max-w-sm p-1 bg-teal-400 border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-xs md:text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                        {{$item['titulo']}} - {{$item['tipo']}}
                    </h5>
                </a>
            @endforeach
        </div>

    </div>
    <livewire:academico.matricula.documento-firmado :id="$matricula->id" />
</div>
