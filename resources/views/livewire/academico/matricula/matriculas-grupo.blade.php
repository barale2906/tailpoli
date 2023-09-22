<div>
    <div class="flex p-4 text-sm text-blue-800 rounded-lg bg-cyan-100 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-bold uppercase text-2xl ">Datos del grupo: {{$grupo->name}}.</span>
            <div class="grid grid-cols-3 gap-3 m-3">
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                        <li>Inicia: <strong>{{$grupo->start_date}}</strong></li>
                        <li>Términa: <strong>{{$grupo->finish_date}}</strong></li>
                        <li>Max Estudiantes: <strong>{{$grupo->quantity_limit}}</strong></li>
                        <li>Estudiantes Inscritos: <strong>{{$grupo->inscritos}}</strong></li>
                        <li>Profesor: <strong>{{$grupo->profesor->name}}</strong></li>
                    </ul>
                </div>
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                        <li>Modulo: <strong>{{$modulo->name}}</strong></li>
                        <li>Curso: <strong>{{$modulo->curso->name}}</strong></li>
                    </ul>
                </div>
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                        <li>Sede: <strong>{{$ciudad->name}}</strong></li>
                        <li>Ciudad: <strong>{{$ciudad->sector->name}}</strong></li>
                    </ul>
                </div>
            </div>
            <span class="font-bold uppercase text-sm ">Horarios:</span>
            <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                    <li><strong>horarios</strong></li>
            </ul>
            <a href="#" wire:click.prevent="$dispatch('Inactivando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
            </a>
        </div>
    </div>
</div>
