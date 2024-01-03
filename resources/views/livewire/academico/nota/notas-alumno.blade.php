<div>
    <div class="relative overflow-x-auto mt-5">
        @if ($notas->count()>0)
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            {{$actual->$porcenv}} %
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            {{$actual->$notaenv}}
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notas as $nota)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$nota->alumno}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$nota->$porcenv}}
                            </th>

                            <th scope="col" class="px-6 py-3" >
                                {{$nota->$notaenv}}
                            </th>

                            <th scope="col" class="p-1" >
                                @if ($nota->aprobo===0)
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="mb-6">
                                            <input type="number" step="any" id="calificacion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nota" wire:model.live="calificacion">
                                        </div>                                        
                                        <a href="" wire:click.prevent="subir({{$nota->id}})"  class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    </div>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3 class="text-center text-blue-800 font-semibold capitalize text-lg">
                No se han registrado calificaciones
            </h3>
        @endif
    </div>
</div>
