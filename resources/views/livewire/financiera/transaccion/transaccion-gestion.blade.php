<div>
    <h2 class="text-center text-lg">
        Transacciones abiertas para <span class="font-bold uppercase">{{$actual->estudiante->name}}</span>
    </h2>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-2 mb-4">

        @foreach ($actual->transacciones as $item)
            @if ($item->status>1 && $item->status<4)
                <a href="" wire:click.prevent="elegida({{$item->id}})" class="text-black bg-gradient-to-r from-gray-300 via-gray-400 to-gray-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-black dark:focus:ring-black font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <div class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                            {{$item->fecha}} - Sede: {{$item->sede->name}} - Creado por: {{$item->creador->name}}
                        </h5>

                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">
                            @if ($item->academico>0)
                                Acádemico: $ {{number_format($item->academico, 0, '.', ' ')}} -
                            @endif
                            @if ($item->inventario>0)
                                Otros: $ {{number_format($item->inventario, 0, '.', ' ')}}
                            @endif
                        </p>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
    @if ($transaccion)

        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-2 mb-4">
            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                @if ($transaccion->extension==="pdf")
                    <a href="{{$url}}" target="_blank">
                        <embed src="{{$url}}" type="application/pdf" width="100%" height="300px" />
                    </a>
                @else
                    <a href="{{$url}}" target="_blank">
                        <img class="rounded-t-lg" src="{{$url}}" alt="{{$url}}" />
                    </a>
                @endif

                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{$transaccion->alumno->name}}
                    </h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{$transaccion->observaciones}}
                    </p>
                    @if ($transaccion->academico>0)
                        <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                            Acádemico: $ {{number_format($transaccion->academico, 0, '.', ' ')}}
                        </p>
                    @endif

                    @if ($transaccion->inventario>0)
                        <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                            Otros: $ {{number_format($transaccion->inventario, 0, '.', ' ')}}
                        </p>
                    @endif
                    <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 capitalize">
                        Sede: {{$transaccion->sede->name}}
                    </p>
                    <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
                        Creado por: {{$transaccion->creador->name}}
                    </p>
                    <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                    </a>

                </div>
            </div>
            <div class="sm:col-span-1 md:col-span-3">
                <h2 class="text-center text-lg">
                    Generar sálida.
                </h2>
                @if ($transaccion->status===2)

                    <livewire:inventario.inventario.inventarios-create :ruta="$ruta" :transaccion="$transaccion->id" />
                @endif

                @if ($transaccion->status===3)
                    <div class="mb-6">
                        <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre Observaciones</label>
                        <textarea id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Describa el objetivo de la transacción" wire:model.live="observaciones">

                        </textarea>
                    </div>
                    @if ($observaciones)
                        <a href="" wire:click.prevent="responder" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Enviar Respuesta
                        </a>
                    @endif
                @endif
            </div>
        </div>
    @endif
</div>
