<div>
    <form wire:submit.prevent="new">
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
            <div class="mb-6">
                <label for="sede_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">A que sede se va a matricular</label>
                <select wire:model.blur="sede_id" wire:change="cursosede()" id="sede" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija sede...</option>
                    @foreach ($sedes as $item)
                        <option value={{$item->id}}>{{$item->name}} - {{$item->sector->name}}</option>
                    @endforeach
                </select>
                @error('sede_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            @if ($sede_id>0)
                <div class="mb-6">
                    <label for="curso_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja el curso</label>
                    <select wire:model.blur="curso_id" id="curso" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize" wire:change="buscaconfiguraciones()">
                        <option >Elija curso...</option>
                        @foreach ($cursos as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('curso_id')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif
            @if ($curso_id && $configPago)
                <div class="mb-6">
                    <label for="config_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja Configuración de Pago</label>
                    <select wire:model.blur="config_id" wire:change="buscaModulos()" id="curso" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija configuración de pago...</option>
                        @foreach ($configPago as $item)
                            <option value={{$item->id}}>{{$item->descripcion}}</option>
                        @endforeach
                    </select>
                    @error('config_id')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif
            @if ($config_id>0)
                <div class="mb-6">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($valor_curso, 0, ',', '.')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor Curso</dd>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($valor_matricula, 0, ',', '.')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor Matricula</dd>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($valor_cuota_inicial, 0, ',', '.')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">Cuota Inicial</dd>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($cuotas, 0, ',', '.')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">N° de Cuotas</dd>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($valor_cuota, 0, ',', '.')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor Cuota</dd>
                    </div>
                </div>
            @endif
        </div>
        <div class="mb-6">
            <div class="w-full">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar Alumno</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input
                        type="search"
                        id="buscar"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="digite nombre o documento del estudiante"
                        wire:model="buscar"
                        wire:keydown="buscAlumno()"
                        autocomplete="off"
                        >
                    <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600" wire:click="limpiar()">
                        Limpiar Filtro
                    </button>
                </div>
            </div>
            @if ($buscar)
                <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                    @foreach ($estudiantes as $item)
                        <li class="w-full mt-2 mb-2 capitalize">
                            {{$item->name}} - {{$item->documento}} <a href="#" wire:click.prevent="selAlumno({{$item}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                                <i class="fa-solid fa-check fa-beat"></i> elegir
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        @if ($alumno_id>0)
            <div class="mb-6">
                <div class="w-full">
                    <p class="max-w-lg text-xl font-semibold leading-normal text-gray-900 dark:text-white">Elegir Grupo(s) para {{$alumnoName}}</p>

                    @if (count($grupocurso))
                        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
                            @foreach ($grupocurso as $item)
                                <a href="#" wire:click.prevent="selGrupo({{$item['id']}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-people-roof fa-beat-fade"></i> {{$item['name']}} - {{$item['modulo']}} -{{$item['profesor']}}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="max-w-lg text-xl font-semibold leading-normal text-gray-900 dark:text-white">No hay grupos para este curso en esta sede.</p>
                    @endif
                </div>
            </div>
        @endif
        @if ($seleccionado)
            <p class="max-w-lg text-xl font-semibold leading-normal text-gray-900 dark:text-white">Grupos Elegidos.</p>
            <div class="grid grid-cols-3 gap-2">
                @foreach ($grupos as $item)
                    <div>
                        <span class="bg-indigo-100 text-indigo-800 text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-indigo-400 border border-indigo-400"><small class="capitalize"> {{$item['name']}}</small></span>
                    </div>
                @endforeach
            </div>
            <hr class="m-5">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <div class="mb-6">
                        <label for="medio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">¿Cómo se entero de nosotros?</label>
                        <select wire:model.blur="medio" id="medio" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elija su respuesta...</option>
                            <option value="Google">Google</option>
                            <option value="Página Web">Página Web</option>
                            <option value="Redes Sociales">Redes Sociales</option>
                            <option value="Referencia">Referencia</option>
                            <option value="Volante">Volante</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('medio')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="mb-6">
                        <label for="nivel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conocimientos Previos</label>
                        <select wire:model.blur="nivel" id="nivel" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elija su respuesta...</option>
                            <option value="Básico">Básico</option>
                            <option value="Intermedio">Intermedio</option>
                            <option value="Avanzado">Avanzado</option>
                            <option value="Ninguno">Ninguno</option>
                        </select>
                        @error('nivel')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="mb-6">
                        <label for="metodo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Método de Pago</label>
                        <select wire:model.blur="metodo" id="metodo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elija su respuesta...</option>
                            <option value="Diferido por Cuotas">Diferido por Cuotas</option>
                            <option value="Contado">Contado</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Cesantías">Cesantías</option>
                        </select>
                        @error('metodo')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="mb-6">
                        <label for="comercial_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asesor Comercial</label>
                        <select wire:model.blur="comercial_id" id="comercial_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elegir AsesorComercial...</option>
                            @foreach ($noestudiantes as $item)
                                <option value={{$item->id}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('comercial_id')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
            >
                Nueva Matricula
            </button>

        @endif
        <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
