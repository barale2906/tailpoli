<div class="mt-3 mb-3">
    @if ($especiales)
        <h1 class="text-center text-xl font-semibold">
            A continuación se presenta la información para <strong class=" uppercase font-extrabold">{{$actual->name}}</strong>, con documento: <strong class=" font-extrabold">{{$actual->documento}}</strong>
        </h1>
    @endif

    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        @if (!$especiales)
            <div class="mb-6">
                <label for="responsable_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Elija alumno</label>
                <select wire:model.live="responsable_id" id="responsable_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija alumno...</option>
                    @foreach ($responsables as $item)
                        <option value={{$item->id_producto}}>{{$item->producto}} - {{$item->almacen}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        @if ($responsable_id>0)
            <div class="flex flex-col items-center justify-center mb-4">
                <dt class="mb-2 text-3xl font-extrabold text-cyan-700">$ {{number_format($total, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Total de la deuda</dd>
            </div>
            <div class="mb-6">
                <label for="tipoconvenio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Tipo de Convenio</label>
                <select wire:model.live="tipoconvenio" id="tipoconvenio" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija ...</option>
                    <option value="1">Total</option>
                    {{-- <option value="2">Aplazamiento</option> --}}
                    <option value="3">Retiro</option>
                </select>
                @error('tipoconvenio')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            @if ($is_total)
                <div class="mb-6">
                    <label for="contado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">forma de Pago</label>
                    <select wire:model.live="contado" id="contado" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija ...</option>
                        <option value="0">Crédito</option>
                        <option value="1">Contado</option>
                    </select>
                    @error('contado')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif


            @if ($is_total)
                @if (!$contado)
                    <div class="mb-6">
                        <label for="valor_inicial" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor inicial</label>
                        <input type="number" id="valor_inicial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Defina el valor" wire:model.live="valor_inicial" wire:keydown="calcuCuota()">
                        @error('valor_inicial')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="cuotas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Número de cuotas{{$saldo>0 ? " Para: $ ".number_format($saldo, 0, '.', ' '):""}}</label>
                        <input type="number" id="cuotas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Número de cuotas" wire:model.live="cuotas" wire:keydown="calcula()">
                        @error('cuotas')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>


                    @if ($cuotas>0)
                        <div class="mb-6">
                            <label for="valor_cuota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor cuota</label>
                            <input type="number" step="any" id="valor_cuota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor de la cuota" wire:model.live="valor_cuota">
                            @error('valor_cuota')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="dia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Día de pago:</label>
                            <select wire:model.live="dia" id="contado" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                <option >Elija ...</option>
                                @foreach ($elegible as $item)
                                    <option value={{$item}}>{{$item}}</option>
                                @endforeach
                            </select>
                            @error('dia')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>
                    @endif

                @endif

            @endif

            @if ($is_aplaza)
                <div class="mb-6">
                    <label for="valor_inicial" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor cuota aplazamiento</label>
                    <input type="number" readonly id="valor_inicial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Defina el valor" wire:model.live="valor_inicial" wire:keydown="calcuCuota()">
                    @error('valor_inicial')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="cuotas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Meses (cuotas de aplazamiento)</label>
                    <input type="number" id="cuotas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Número de cuotas" wire:model.live="cuotas" wire:keydown="calculafectadas()">
                    @error('cuotas')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>


                @if ($cuotas>0)
                    <div class="mb-6">
                        <label for="valor_cuota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor cuota</label>
                        <input type="number" step="any" id="valor_cuota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Valor de la cuota" wire:model.live="valor_cuota">
                        @error('valor_cuota')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="dia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Día de pago:</label>
                        <select wire:model.live="dia" id="contado" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elija ...</option>
                            @foreach ($elegible as $item)
                                <option value={{$item}}>{{$item}}</option>
                            @endforeach
                        </select>
                        @error('dia')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif
            @endif

            @if ($is_retiro)
                <div class="mb-6">
                    <label for="valor_inicial" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Valor cuota de retiro</label>
                    <input type="number" id="valor_inicial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Defina el valor" wire:model.live="valor_inicial" wire:keydown="calcuCuota()">
                    @error('valor_inicial')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
            @endif

            <div class="mb-6">
                <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha pago: <span class=" text-xs text-red-600">(Pago inicial o valor total o Cuota de Retiro)</span></label>
                <input type="date" id="fecha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-3"  wire:model.live="fecha" required>
                @error('fecha')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Descripción</label>
                <input type="text" id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descripción del acuerdo" wire:model.live="descripcion">
                @error('descripcion')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>


            @if ($descripcion && $fecha && $tipoconvenio)
                <button
                    class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                    wire:click="crea"
                >
                    Nuevo Convenio
                </button>
            @endif
            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-backward"></i> Volver
            </a>

        @endif
    </div>
    @if ($responsable_id>0)
        @if ($deudas->count()>0)
            <div class="relative overflow-x-auto">
                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3" >

                            </th>
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
                                    <div class=" mb-3">
                                        <a href="" wire:click.prevent="eliminar({{$deuda->id}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-trash-can-arrow-up"></i>
                                        </a>
                                    </div>

                                    @if ($deuda->id===$id_elimina)
                                    <div class=" mb-3 mt-3">
                                        <input type="text" id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Registre el motivo" wire:model.live="observaciones">
                                    </div>

                                        @if ($observaciones)
                                            <div class=" mb-3 mt-3">
                                                <a href="" wire:click.prevent="anular" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> Confirme la anulación
                                                </a>
                                            </div>
                                        @endif
                                    @endif

                                </th>
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
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$deuda->observaciones}}
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h1 class=" text-center capitalize">
                El estudiante no tiene cartera registrada.
            </h1>
        @endif

    @endif
</div>
