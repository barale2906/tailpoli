@if ($is_filtro)
    @if ($is_campo)
        <div class="w-full">
            <label for="search" class="mb-2 text-xs font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
            <h1 class="text-center text-xs md:text-lg font-semibold">{{$txt}}</h1>
            <div class="relative">
                <input
                    type="search"
                    id="buscar"
                    class="block w-full p-4 pl-10 text-xs md:text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="ingrese datos"
                    wire:model.live="buscar"
                    wire:keydown="buscaText()"
                    >

            </div>
        </div>
    @endif

@else


    <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-xs md:text-xl font-bold text-gray-900 dark:text-white">Seleccione los parámetros de filtrado </h5>

        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
            @if ($is_campo)
                <div class="w-full sm:col-span-1 md:col-span-4">
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar: </label>
                    <h1 class="text-center text-xs md:text-lg font-semibold">{{$txt}}</h1>
                    <div class="relative">

                        <input
                            type="search"
                            id="buscar"
                            class="block w-full p-4 pl-10 text-xs md:text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ingrese datos"
                            wire:model.live="buscar"
                            wire:keydown="buscaText()"
                            >
                    </div>
                </div>
            @endif
            @if ($is_Creades)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtroCreades" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Fecha de creación</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroCreades" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreades" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroCreahas" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreahas" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                </div>
            @endif

            @if ($is_grado)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtroInigra" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Fecha de graduación</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroInigra" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroInigra" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroFingra" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroFingra" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                </div>
            @endif

            @if ($is_fechatransaccion)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtrTransades" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Fecha de transacción</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroTransdes" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroTransdes" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroTranshas" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroTranshas" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                </div>
            @endif

            @if ($is_vencimiento)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtroCreades" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Fecha de vencimiento</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroVendes" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreades" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    @if ($filtroVendes)
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="date" wire:model.live="filtroVenhas" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                            <label for="filtroCreahas" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                        </div>
                    @endif
                </div>

                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroCiudad" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
                    <select wire:model.live="filtroCiudad" id="filtroCiudad"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >ciudad</option>
                        @foreach ($ciudades as $item)
                            <option value={{$item->sector_id}}>{{$item->sector->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_sede) {{-- desde consulta --}}
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroSede" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Sede</label>
                    <select wire:model.live="filtroSede" id="filtroSede"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >sede</option>
                        @foreach ($sedes as $item)
                            <option value={{$item->sede_id}}>{{$item->sede->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_sedecurso) {{-- sede donde el estudiante toma el curso --}}
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrosedecurso" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Sede donde toma el curso</label>
                    <select wire:model.live="filtrosedecurso" id="filtrosedecurso"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >sede toma curso</option>
                        @foreach ($sedes as $item)
                            <option value={{$item->sede_id}}>{{$item->sede->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_cajero)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrocajero" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Cajero</label>
                    <select wire:model.live="filtrocajero" id="filtrocajero"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Cajero...</option>
                        @foreach ($cajeros as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_conceptopag)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroconcepto" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Conceptos de pago</label>
                    <select wire:model.live="filtroconcepto" id="filtroconcepto"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Concepto...</option>
                        @foreach ($conpagos as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_medio)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtromedio" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Medio de Pago</label>
                    <select wire:model.live="filtromedio" id="filtromedio"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Medio...</option>
                        <option value="PSE">PSE</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="cheque">Cheque</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                    </select>
                </div>
            @endif

            @if ($is_sededir) {{-- desde la tabla directa --}}
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroSede" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Sede</label>
                    <select wire:model.live="filtroSede" id="filtroSede"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >sede</option>
                        @foreach ($asignadas as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_Inides)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtroInides" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroInides" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"/>
                        <label for="filtroInides" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroInihas" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                        <label for="filtroInihas" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                </div>
            @endif

            @if ($is_matri)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtromatri" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Registro</label>
                    <select wire:model.live="filtromatri" id="filtromatri"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Matriculo</option>
                        @foreach ($usuMatriculo as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="filtrocom" id="filtrocom"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Comercial</option>
                        @foreach ($usuComercial as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_curso)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrocurso" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Curso</label>
                    <select wire:model.live="filtrocurso" id="filtrocurso"
                    class="block py-2.5 px-2.5 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Curso...</option>
                        @foreach ($cursos as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_grupo)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrogrupo" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Grupo</label>
                    <select wire:model.live="filtrogrupo" id="filtrogrupo"
                    class="block py-2.5 px-2.5 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Grupo...</option>
                        @foreach ($grupos as $item)
                            <option value={{$item->id}}>{{$item->id}} - {{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_profesor)
                @if ($no_soy_profe)
                    <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                        <label for="filtroprofesor" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Profesores</label>
                        <select wire:model.live="filtroprofesor" id="filtroprofesor"
                        class="block py-2.5 px-2.5 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                            <option >Profesor...</option>
                            @foreach ($profesores as $item)
                                <option value={{$item->id}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endif

            @if ($is_etapa)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroetapa" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Étapa de Cobro</label>
                    <select wire:model.live="filtroetapa" id="filtroetapa"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Étapa...</option>
                        <option value=1>Inicia Proceso de cobro</option>
                        <option value=2>Pre - Reporte</option>
                        <option value=3>Reporte</option>
                        <option value=4>Post - Reporte</option>
                    </select>
                </div>
            @endif

            @if ($is_jornada)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrojornada" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Jornada</label>
                    <select wire:model.live="filtrojornada" id="filtrojornada"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Elija Jornada...</option>
                        <option value=1>Mañana</option>
                        <option value=2>Tarde</option>
                        <option value=3>Noche</option>
                        <option value=4>Fin de Semana</option>
                    </select>
                </div>
            @endif

            @if ($is_tipo)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrotipo" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                    <select wire:model.live="filtrotipo" id="filtrotipo"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Tipo...</option>
                        @foreach ($tipo as $item)
                            <option value={{$item['id']}}>{{$item['nombre']}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_almacen)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroalmacen" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Almacen</label>
                    <select wire:model.live="filtroalmacen" id="filtroalmacen"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >almacén ...</option>
                        @foreach ($almacenes as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_saldo)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="Saldofiltro" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Obtener Saldo</label>
                    <select wire:model.live="Saldofiltro" id="Saldofiltro"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option>Obtiene ...</option>
                        <option value="si">SI</option>
                        <option value="no">No</option>
                    </select>
                </div>
            @endif

            @if ($is_rol)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrorol" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                    <select wire:model.live="filtrorol" id="filtrorol"
                    class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Tipo...</option>
                        @foreach ($roles as $item)
                            <option value={{$item->name}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif


            {{-- @if ($is_estatumatri)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="estadoMatricula" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                    <select wire:model.live="estadoMatricula" id="estadoMatricula"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Matricula</option>
                        <option value="1">Activa</option>
                        <option value="0">Anulada</option>
                    </select>
                    {{$filtroestatumatri}}
                </div>
            @endif --}}

            @if ($is_transaccion)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="estado" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                    <select wire:model.live="estado" id="estado"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Estado transaccion</option>
                        <option value=1>Creada</option>
                        <option value=2>Pendiente Entrega Inventario</option>
                        <option value=3>Devuelto</option>
                        <option value=4>Cerrada</option>
                    </select>
                </div>
            @endif

            @if ($is_status_est)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="estado_estudiante" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                    <select wire:model.live="estado_estudiante" multiple id="estado_estudiante"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Estado estudiante</option>
                        @foreach ($status_estu as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_status_cart)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="estado_cartera" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Estado Cartera</label>
                    <select wire:model.live="estado_cartera" multiple id="estado_cartera"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Estado cartera... </option>
                        @foreach ($estacartera as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_ciclos)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrociclo" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Programación</label>
                    <select wire:model.live="filtrociclo" id="filtrociclo"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Elija programación... </option>
                        @foreach ($ciclos as $item)
                            <option value={{$item->id}}><strong>INICIA: {{$item->inicia}}</strong> /// NOMBRE: {{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_ciclos_crono)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrociclo" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Programación</label>
                    <select wire:model.live="filtrociclo" id="filtrociclo"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Elija programación... </option>
                        @foreach ($ciclos as $item)
                            <option value={{$item->ciclo_id}}><strong>INICIA: {{$item->ciclo->inicia}}</strong> /// NOMBRE: {{$item->ciclo->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_control)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrotipo_curso" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Tipo de Curso</label>
                    <select wire:model.live="filtrotipo_curso" id="filtrotipo_curso"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Tipo curso</option>
                        <option value=1>Práctico</option>
                        <option value=2>Técnico</option>
                    </select>
                </div>
            @endif

            @if ($is_acta && $filtrotipo_curso>0)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroacta" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Seleccione Acta</label>
                    <select wire:model.live="filtroacta" id="filtroacta"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Elija acta... </option>
                        @foreach ($actas as $item)
                            <option value={{$item->id}}><strong>ACTA: {{$item->acta}}</strong> /// CURSO: <span class=" uppercase">{{$item->titulo}}</span></option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    </div>

@endif

@if ($is_verfiltro)
    <a href=""  class="w-auto text-black  bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-medium rounded-lg text-xs md:text-sm px-2 py-2 text-center capitalize" >
        <i class="fa-solid fa-eraser"></i>
    </a>
    <a href="" wire:click.prevent="filtroMostrar" class="w-auto text-black  bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-xs md:text-sm px-2 py-2 text-center capitalize" >
        <i class="fa-solid fa-filter"></i>
    </a>
@endif

