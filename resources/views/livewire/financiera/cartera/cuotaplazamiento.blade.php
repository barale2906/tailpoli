<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">cuotas de aplazamiento</h1>
    </div>

    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mb-4">
        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
            <label for="observaciones" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                Cuota de aplazamiento
            </label>
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model.live="valor" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                <label for="valor" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Valor</label>
            </div>
            <div class="inline-flex rounded-md shadow-sm" role="group">
                @if ($valor )
                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-green-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-2 focus:ring-green-700 focus:text-green-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-green-500 dark:focus:text-white">
                        <a href="" wire:click.prevent="crea" class="inline-flex items-center font-medium text-green-600 dark:text-green-500 hover:underline">
                            <i class="fa-solid fa-check"></i>
                        </a>
                    </button>
                @endif
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor')">
                            Valor
                            @if ($ordena != 'valor')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('created_at')">
                            Fecha Creación
                            @if ($ordena != 'created_at')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cuotas as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$recibo->valor}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->created_at}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-blue-100">
                <div>
                    <label class="relative inline-flex items-center mb-4 cursor-pointer">
                        <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                        <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=15>15</option>
                            <option value=20>20</option>
                            <option value=50>50</option>
                            <option value=100>100</option>
                        </select>
                    </label>
                </div>
                <div>
                    {{ $cuotas->links() }}
                </div>
            </div>
        </div>
    </div>


</div>
