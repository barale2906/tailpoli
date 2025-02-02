<div>
    @if ($vista)
        <form wire:submit.prevent="new">
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
                <p class="text-xl font-semibold leading-normal text-gray-900 dark:text-white">
                    Generar Matricula para <span class=" font-extrabold uppercase">{{$alumnoName}}</span> documento: {{$alumnodocumento}}
                </p>
                <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
                    <div class="mb-6">
                        <label for="sede_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">A que sede se va a matricular</label>
                        <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
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
                            <select wire:model.live="curso_id" id="curso" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
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
                            <select wire:model.live="config_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
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
                <p class="text-xl font-semibold leading-normal text-gray-900 dark:text-white">
                    @if ($plan)
                        Ver plan de estudio en el siguiente link: <a href="{{Storage::url($plan->ruta_pdf)}}" target="_blank">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-red-900 bg-red-900 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                <i class="fa-solid fa-file-pdf"></i> PDF
                            </button>
                        </a>,
                    @endif
                    Estos modulos estan incluidos en la matricula:
                </p>
                @if ($modulos)
                    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
                        @foreach ($modulos as $item)
                            <span class="bg-indigo-100 text-indigo-800 text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-indigo-400 border border-indigo-400">
                                <i class="fa-solid fa-people-roof fa-beat-fade"></i><small class="capitalize"> {{$item->name}}</small>
                            </span>
                        @endforeach
                    </div>
                @endif
            @endif
            @if ($is_incompleto)
                <a href="{{route('academico.estudiantes')}}">
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span> Debe diligenciar toda la información del estudiante: <span class="uppercase font-extrabold">{{$alumnoName}}</span> para generar la matricula.<br>
                        Para hacerlo:
                        <ul>
                            <li>- Haga clic aquí.</li>
                            <li>- Busque el estudiante.</li>
                            <li>- De clic en el icono VERDE.</li>
                        </ul>
                    </div>
                </a>
            @endif
            @if ($curso_id>0 && $alumno_id>0 && $config_id>0)
                <div class="mb-6">
                    <label for="ciclo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Seleccione Fecha de Inicio</label>
                    <select wire:model.live="ciclo_id" id="ciclo_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija ...</option>
                        @foreach ($ciclos as $item)
                            <option value={{$item->id}}>
                                @switch($item->jornada)
                                    @case(1)
                                        MAÑANA - {{$item->name}} {{-- - Inicia: {{$item->inicia}} --}}
                                        @break
                                    @case(2)
                                        TARDE - {{$item->name}} {{-- - Inicia: {{$item->inicia}} --}}
                                        @break
                                    @case(3)
                                        NOCHE - {{$item->name}} {{-- - Inicia: {{$item->inicia}} --}}
                                        @break
                                    @case(4)
                                        FIN DE SEMANA - {{$item->name}} {{-- - Inicia: {{$item->inicia}} --}}
                                        @break

                                @endswitch
                            </option>
                        @endforeach
                    </select>
                    @error('ciclo_id')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

                @if ($horarios)
                    <h1 class="text-center text-lg">
                        Inicia el <span class="font-extrabold uppercase">{{$primerGrupo->fecha_inicio}}</span> con el modulo <span class="font-extrabold uppercase">{{$primerGrupo->grupo->modulo->name}}</span> en el siguiente horario:
                    </h1>

                    <div class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 sm:grid-cols-1 md:grid-cols-7 bg-white dark:bg-gray-800">
                        @for ($i = 1; $i <= 7; $i++)
                            <figure class="flex flex-col items-center p-4 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                                <blockquote class="max-w-2xl mx-auto mb-2 text-gray-500 lg:mb-8 dark:text-gray-400">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white uppercase">
                                        @switch($i)
                                            @case(1)
                                                lunes
                                                @break
                                            @case(2)
                                                martes
                                                @break
                                            @case(3)
                                                miércoles
                                                @break
                                            @case(4)
                                                jueves
                                                @break
                                            @case(5)
                                                viernes
                                                @break
                                            @case(6)
                                                sábado
                                                @break
                                            @case(7)
                                                domingo
                                                @break
                                        @endswitch
                                    </h3>
                                </blockquote>
                                <figcaption class="flex items-center justify-center ">
                                    <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                        @foreach ($horarios as $item)
                                                @switch($i)
                                                    @case(1)
                                                        @if ($item->periodo && $item->dia==="lunes")
                                                            <div>
                                                                <strong>{{$item->area->name}}</strong>: <strong>{{$item->hora}}</strong>
                                                            </div>
                                                        @endif

                                                        @break
                                                    @case(2)
                                                        @if ($item->periodo && $item->dia==="martes")
                                                            <div>
                                                                <strong>{{$item->area->name}}</strong>: <strong>{{$item->hora}}</strong>
                                                            </div>
                                                        @endif

                                                        @break
                                                    @case(3)
                                                        @if ($item->periodo && $item->dia==="miercoles")
                                                            <div>
                                                                <strong>{{$item->area->name}}</strong>: <strong>{{$item->hora}}</strong>
                                                            </div>
                                                        @endif

                                                        @break
                                                    @case(4)
                                                        @if ($item->periodo && $item->dia==="jueves")
                                                            <div>
                                                                <strong>{{$item->area->name}}</strong>: <strong>{{$item->hora}}</strong>
                                                            </div>
                                                        @endif

                                                        @break
                                                    @case(5)
                                                        @if ($item->periodo && $item->dia==="viernes")
                                                            <div>
                                                                <strong>{{$item->area->name}}</strong>: <strong>{{$item->hora}}</strong>
                                                            </div>
                                                        @endif

                                                        @break
                                                    @case(6)
                                                        @if ($item->periodo && $item->dia==="sabado")
                                                            <div>
                                                                <strong>{{$item->area->name}}</strong>: <strong>{{$item->hora}}</strong>
                                                            </div>
                                                        @endif

                                                        @break
                                                    @case(7)
                                                        @if ($item->periodo && $item->dia==="domingo")
                                                            <div>
                                                                <strong>{{$item->area->name}}</strong>: <strong>{{$item->hora}}</strong>
                                                            </div>
                                                        @endif

                                                        @break
                                                @endswitch


                                        @endforeach
                                    </div>
                                </figcaption>
                            </figure>
                        @endfor
                    </div>

                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="mb-6">
                            <label for="medio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">¿Cómo se entero de nosotros?</label>
                            <select wire:model.blur="medio" id="medio" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option >Elija su respuesta...</option>
                                <option value="Google">Google</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Tik Tok">Tik Tok</option>
                                <option value="X">X</option>
                                <option value="Página Web">Página Web</option>
                                <option value="Recomendación">Recomendación</option>
                                <option value="Referencia">Referencia</option>
                                <option value="Volante">Volante</option>
                                <option value="Correo Electrónico">Correo Electrónico</option>
                                <option value="Visita en sitio">Visita en sitio</option>
                                <option value="Visita sitio web">Visita sitio web</option>
                            </select>
                            @error('medio')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>
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
                        {{--
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
                        </div> --}}
                        <div class="mb-6">
                            <label for="comercial_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asesor Comercial</label>
                            <select wire:model.live="comercial_id" id="comercial_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        @if ($is_comercial)
                            <div class="p-4 mb-4 text-lg text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">!Estas Seguro(a)!</span> ¿Fuiste tú quien hizo la Gestión Comercial?.
                            </div>
                        @endif
                    </div>
                @endif


            @endif

            <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4">
                @if ($curso_id>0 && $alumno_id>0 && $config_id>0 && $ciclo_id>0)
                    <button type="submit"
                    class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                    >
                        Nueva Matricula
                    </button>
                @endif
                <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </div>
        </form>
    @else


        <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                Se genero la matricula de: <span class=" uppercase">{{$alumnoName}}</span>
            </h5>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                Por favor genere los documentos respectivos para su firma y el recibo de caja para registar el pago.
            </p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                <a href="" wire:click.prevent="documentos()"  class="w-full sm:w-auto bg-orange-800 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-orange-700 dark:hover:bg-orange-600 dark:focus:ring-orange-700">
                    <i class="fa-solid fa-file-pdf mr-2"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Descargar documentos</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">PDF</div>
                    </div>
                </a>
                @if ($genrecibo && $finrecibo)
                    <a href="" wire:click.prevent="transferencia()" class="w-full sm:w-auto bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                        <div class="text-left rtl:text-right">
                            <div class="mb-1 text-xs">Guardar observación</div>
                            <div class="-mt-1 font-sans text-sm font-semibold">Transferencia</div>
                        </div>
                    </a>
                    <a href="" wire:click.prevent="recibo()" class="w-full sm:w-auto bg-green-800 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-green-700 dark:hover:bg-green-600 dark:focus:ring-green-700">
                        <i class="fa-solid fa-file-invoice-dollar mr-2"></i>
                        <div class="text-left rtl:text-right">
                            <div class="mb-1 text-xs">Generar</div>
                            <div class="-mt-1 font-sans text-sm font-semibold">Recibo de Caja</div>
                        </div>
                    </a>
                @endif
                @if ($genrecibo && !$finrecibo)
                    <a href="" wire:click.prevent="$dispatch('cancelando')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                        <i class="fa-solid fa-backward mr-2"></i>
                        <div class="text-left rtl:text-right">
                            <div class="mb-1 text-xs">Volver al listado</div>
                            <div class="-mt-1 font-sans text-sm font-semibold">Finalizar</div>
                        </div>
                    </a>
                @endif


            </div>
        </div>
        @if (!$genrecibo)
            <livewire:financiera.recibo-pago.recibos-pago-crear :ruta="$ruta" :estudiante="$alumno_id"/>
        @endif
        @if ($is_document)
            <livewire:academico.matricula.documentos :elegido="$elegido" />
    @endif

    @endif
</div>
