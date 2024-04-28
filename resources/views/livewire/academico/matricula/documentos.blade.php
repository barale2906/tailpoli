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

        <div class="md:inline-flex rounded-md shadow-sm" role="group">

            @foreach ($documentos as $item)
                <a href="{{$item['ruta']}}" target="_blank">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-blue-150 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        {{$item['titulo']}} - {{$item['tipo']}}
                    </button>
                </a>
            @endforeach

        </div>

    </div>
    <livewire:academico.matricula.documento-firmado :id="$matricula->id" />
</div>
