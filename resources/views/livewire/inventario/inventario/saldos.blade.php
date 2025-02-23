<div>
    <div class="flex flex-wrap justify-end mb-4 ">
        <a href="#" wire:click.prevent="$dispatch('cancelando')" class="w-auto text-teal-600 bg-gradient-to-r from-teal-100 via-teal-300 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-100 dark:focus:ring-teal-600 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
            <i class="fa-solid fa-backward-step"></i> Volver
        </a>
        <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
            <i class="fa-solid fa-file-excel fa-beat"></i>
        </a>
    </div>
    <div class="relative overflow-x-auto">
        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" >
                        PRODUCTO
                    </th>
                    @foreach ($almacenes as $item)
                        <th scope="col" class="px-6 py-3" >
                            {{$item->name}}
                        </th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                @foreach ($totales as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white uppercase">
                            {{$item['producto']}}
                        </th>
                        @for ($i = 0; $i < $almacenes->count(); $i++)
                            @php
                                $almaid=$almacenes[$i]->id // Id del almacen
                            @endphp
                            @if (isset($item[$almaid]))
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-center dark:text-white capitalize">
                                    {{$item[$almacenes[$i]->id]}}
                                </th>
                            @endif
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>
