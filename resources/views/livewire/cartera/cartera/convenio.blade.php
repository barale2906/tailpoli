<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
        <div class="mb-6">
            <label for="responsable_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Elija alumno</label>
            <select wire:model.live="responsable_id" id="responsable_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija alumno...</option>
                @foreach ($responsables as $item)
                    <option value={{$item->id_producto}}>{{$item->producto}} - {{$item->almacen}}</option>
                @endforeach
            </select>
        </div>
        @if ($responsable_id>0)
            <div class="flex flex-col items-center justify-center mb-4">
                <dt class="mb-2 text-3xl font-extrabold text-cyan-700">$ {{number_format($total, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Total de la deuda</dd>
            </div>
        @endif
    </div>
    @if ($responsable_id>0)
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Fecha Programada
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Fecha registro
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Valor
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Saldo
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Estudiante
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Concepto
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Observaciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deudas as $deuda)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$deuda->fecha_pago}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$deuda->fecha_real}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($deuda->valor, 0, ',', '.')}}
                            </th>

                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($deuda->saldo, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$deuda->responsable->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$deuda->concepto}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$deuda->observaciones}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
