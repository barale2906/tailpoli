@if ($is_filtro)
    <div class="w-full">
        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
        <h1 class="text-center text-lg font-semibold">{{$txt}}</h1>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input
                type="search"
                id="buscar"
                class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por grupo o nombre estudiante o documento estudiante o método de pago"
                wire:model="buscar"
                wire:keydown="buscaText()"
                >
            <a href="">
                <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600" wire:click="limpiar()">
                    Limpiar Filtro
                </button>
            </a>
        </div>
    </div>
@else


    <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Seleccione los parámetros de filtrado </h5>

        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
            <div class="w-full sm:col-span-1 md:col-span-4">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar: </label>
                <h1 class="text-center text-lg font-semibold">{{$txt}}</h1>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>

                    <input
                        type="search"
                        id="buscar"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por grupo o nombre estudiante o documento estudiante o método de pago"
                        wire:model="buscar"
                        wire:keydown="buscaText()"
                        >
                        <a href="">
                            <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600" wire:click="limpiar()">
                                Limpiar Filtro
                            </button>
                        </a>
                </div>
            </div>
            @if ($is_Creades)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtroCreades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de creación</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroCreades" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreades" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroCreahas" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreahas" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                </div>
            @endif

            @if ($is_Inides)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtroInides" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroInides" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"/>
                        <label for="filtroInides" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroInihas" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                        <label for="filtroInihas" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                </div>
            @endif

            @if ($is_matri)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtromatri" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registro</label>
                    <select wire:model.live="filtromatri" id="filtromatri"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Matriculo</option>
                        @foreach ($usuMatriculo as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="filtrocom" id="filtrocom"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Comercial</option>
                        @foreach ($usuComercial as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_curso)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrocurso" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Curso</label>
                    <select wire:model.live="filtrocurso" id="filtrocurso"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Curso...</option>
                        @foreach ($cursos as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($is_tipo)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtrotipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                    <select wire:model.live="filtrotipo" id="filtrotipo"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                        <option >Tipo...</option>
                        @foreach ($tipo as $item)
                            <option value={{$item['id']}}>{{$item['nombre']}}</option>
                        @endforeach
                    </select>
                </div>
            @endif


            @if ($is_estatumatri)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="estadoMatricula" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                    <select wire:model.live="estadoMatricula" id="estadoMatricula"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Matricula</option>
                        <option value="1">Activa</option>
                        <option value="0">Anulada</option>
                    </select>

                    <select wire:model.live="filtroestatualum" id="filtroestatualum"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option >Estudiante</option>
                        <option value="">//</option>
                    </select>
                </div>
            @endif

        </div>
    </div>

@endif

<a href="" wire:click.prevent="filtroMostrar" class="w-auto text-black bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
    <i class="fa-solid fa-filter"></i>
</a>
