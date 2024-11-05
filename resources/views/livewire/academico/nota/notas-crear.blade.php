<div>
    <form wire:submit.prevent="new">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
            @hasrole('Profesor')

            @else
                <div class="mb-6">
                    <label for="profesor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Elija el profesor</label>
                    <select wire:model.live="profesor_id" id="profesor" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija profesor...</option>
                        @foreach ($profesores as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('profesor_id')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endrole
            @if ($profesor_id>0)
                <div class="mb-6">
                    <label for="jornada_id" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Jornada</label>
                    <select wire:model.live="jornada_id" id="jornada_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija Jornada...</option>
                        <option value=1>Mañana</option>
                        <option value=2>Tarde</option>
                        <option value=3>Noche</option>
                        <option value=4>Fin de Semana</option>
                    </select>
                </div>
            @endif

            @if ($profesor_id>0 && $jornada_id>0)
                @if ($grupos->count()>0)
                    <div class="mb-6">
                        <label for="grupo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Elija el grupo</label>
                        <select wire:model.live="grupo_id" id="grupo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elija grupo...</option>
                            @foreach ($grupos as $item)
                                <option value={{$item->id}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('grupo_id')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @else
                    <p class="text-center text-lg capitalize">No tiene grupos activos</p>
                @endif


            @endif
        </div>

        @if ($crt)
            @if ($profesor_id>0 && $grupo_id)
                <div class="grid grid-cols-2 gap-3 bg-slate-300 m-3 p-3">
                    @if (count($cargados)<10 && $Total<100)
                        <div class="grid grid-cols-4 gap-3 m-1 p-1">

                            <div class="mb-6">
                                <label for="nota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de la nota</label>
                                <input type="text" id="nota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="descripción de la nota" wire:model.live="nota">
                                @error('nota')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="porcentaje" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Porcentaje de la nota</label>
                                <input type="text" id="porcentaje" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Peso porcentual de la nota. Solo números" wire:model.live="porcentaje">
                                @error('porcentaje')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                    </div>
                                @enderror
                            </div>
                            <div>
                                @if ($nota && $porcentaje>0 )
                                <label for="temporal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar</label>
                                    <a href="#" wire:click.prevent="temporal()"  class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                        <i class="fa-solid fa-check"></i>
                                    </a>
                                @endif
                            </div>

                        </div>
                    @else
                        No puede cargar mas de diez (10) notas o mas del 100 % de ponderación.
                    @endif

                    <div class="ring-2 bg-gray-50 p-2">
                        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            Total: {{number_format($Total, 2, ',', '.')}} % - Registros: {{count($cargados)}}
                        </h5>

                        @if ($cargados)

                            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" >
                                            Nota
                                        </th>
                                        <th scope="col" class="px-6 py-3" >
                                            Porcentaje
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cargados as $otros)

                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                    {{$otros['nota']}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                    {{$otros['porcentaje']}}
                                                </th>
                                                <th>
                                                    <a href="#" wire:click.prevent="elimOtro({{$otros['contador']}})"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </th>
                                            </tr>

                                    @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>
                </div>
            @endif
        @else
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡ATENCIÓN!</span> Ya existe una configuración de notas para este grupo y profesor.
            </div>
        @endif



        <div class="mb-6">
            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Descripción</label>
            <input type="text" id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descripción de la configuración" wire:model.blur="descripcion">
            @error('descripcion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
            @if ($cargados && $Total==100)
                <button type="submit"
                    class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize"
                >
                <i class="fa-solid fa-upload"></i> Nuevo Esquema de Notas
                </button>
            @endif
            <a href="" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
    </form>

</div>
