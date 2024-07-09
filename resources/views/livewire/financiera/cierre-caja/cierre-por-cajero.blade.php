<div>
    @if ($is_dia)
        @if (!$print)
            @if ($recibos->count()>0)
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        @if ($this->agrupado->count()===1)
                            <h4 class="text-center text-2xl">
                                Generar cierre para la sede: <strong class="uppercase">{{$unica->sede->name}}</strong>
                            </h4>
                        @else
                            <div class="mb-6">
                                <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                    <option >Elija sede...</option>
                                    @foreach ($sedes as $item)
                                        <option value={{$item['id']}}>{{$item['id']}} - {{$item['name']}}</option>
                                    @endforeach
                                </select>
                                @error('sede_id')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                    </div>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-6">
                            <label for="comentarios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                            <input type="text" id="comentarios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Observaciones del cierre" wire:model.live="comentarios" autocomplete="off">

                            @error('comentarios')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="dinero_entegado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Efectivo entregado, descontando dinero de base</label>
                            <input type="text" id="dinero_entegado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="dinero entregado" wire:model.live="dinero_entegado" autocomplete="off">

                            @error('dinero_entegado')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div>
                        @if ($sede_id>0)
                            <h5 class="text-semibold md:text-lg sm:text-sm capitalize m-3">Recibos de caja encontrados</h5>
                            <table class=" text-sm text-left text-gray-500 dark:text-gray-400 m-2">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" >
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Fecha
                                        </th>
                                        <th scope="col" class="px-6 py-3" >
                                            Alumno
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Observaciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recibos as $recibo)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$recibo->numero_recibo}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                {{$recibo->fecha}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                {{$recibo->paga->name}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                                {{$recibo->observaciones}}
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
                    @if ($sede_id>0)

                        <button type="button" wire:click.prevent="test" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Default</button>

                    @endif

                    <div>
                        <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-2 capitalize">
                            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                        </a>
                    </div>
                </div>
            @else
                <h2 class="md:text-2xl font-bold text-gray-900 dark:text-white">
                    No tienes recibos registrados para realizar CIERRE
                </h2>
                <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                </a>
            @endif
        @else
            <livewire:financiera.cierre-caja.cierre-cajas-imprimir :elegido="$elegido" :accion="$accion" :ruta="$ruta"/>
        @endif
    @else
        @include('includes.cajaCerrada')
    @endif

</div>
