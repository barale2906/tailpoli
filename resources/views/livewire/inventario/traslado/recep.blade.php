<div>
    <h2 class="text-center font-semibold text-lg">
        Va a recibir los traslados para el almacén: <span class="uppercase font-extrabold"> {{$almacen->name}}</span> de la sede: <span class="uppercase font-extrabold">{{$almacen->sede->name}}</span>
    </h2>
    @if (count($documentos)>0)

        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-3 bg-slate-300 m-3 p-3">
            <div class="mb-6 text-center">
                <label for="tras" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja documento</label>
                <select wire:model.live="tras" id="tras" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                    <option >Elija documento...</option>
                    @foreach ($documentos as $item)
                            <option value={{$item['traslado']}}>{{$item['traslado']}} - {{$item['fecha_movimiento']}}</option>
                    @endforeach
                </select>
            </div>
            @if ($tras>0)
                <div class="ring-2 bg-gray-50 p-2">
                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" >
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    Cantidad
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($traslados as $otros)

                                @if ($otros->traslado==$tras)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$otros->producto->name}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                            {{$otros->cantidad}}
                                        </th>
                                        <th>
                                            <a href="#" wire:click.prevent="temporal({{$otros->id}})"  class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                <i class="fa-solid fa-check"></i>
                                            </a>

                                            @if ($id_mov===$otros->id)
                                                <a href="#" wire:click.prevent="aprobar({{$otros}})"  class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> Confirme Recepción
                                                </a>
                                            @endif

                                        </th>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    @else
        <p class="text-center capitalize text-lg">
            No hay remisiones pendientes para esta sede.
        </p>
    @endif

</div>
