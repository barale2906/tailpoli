<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-2 mb-4">

        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            @if ($actual->extension==="pdf")
                <a href="{{$url}}" target="_blank">
                    <embed src="{{$url}}" type="application/pdf" width="100%" height="300px" />
                </a>
            @else
                <a href="{{$url}}" target="_blank">
                    <img class="rounded-t-lg" src="{{$url}}" alt="{{$url}}" />
                </a>
            @endif
            <div class="p-5">
                <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{$this->actual->alumno->name}}
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    {{$this->actual->observaciones}}
                </p>
                @if ($this->actual->academico>0)
                    <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                        Acádemico: $ {{number_format($this->actual->academico, 0, '.', ' ')}}
                    </p>
                @endif

                @if ($this->actual->inventario>0)
                    <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                        Otros: $ {{number_format($this->actual->inventario, 0, '.', ' ')}}
                    </p>
                @endif
                <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 capitalize">
                    Sede: {{$this->actual->sede->name}}
                </p>
                <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
                    Creado por: {{$this->actual->creador->name}}
                </p>
                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>

            </div>
        </div>
        @if ($is_recibo)
            <div class="sm:col-span-1 md:col-span-3">
                <livewire:financiera.recibo-pago.recibos-pago-crear :ruta="$ruta" :elegido="$this->actual->id"/>
            </div>
        @else
            <div class="grid sm:grid-cols-1 md:col-span-3 gap-2 mb-4">
                @if ($this->actual->inventario>0 && !$this->actual->status_inventario)
                    <div class="mb-6">
                        <label for="opcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aprueba movimiento de inventario</label>
                        <select wire:model.live="opcion" id="opcion" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elija opción...</option>
                            <option value=1>Si</option>
                            <option value=2>No</option>
                        </select>
                    </div>
                    @if ($opcion==="2")
                        <div class="mb-6">
                            <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre Observaciones</label>
                            <textarea id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Describa el objetivo de la transacción" wire:model.live="observaciones">

                            </textarea>
                        </div>
                    @endif
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                        @if ($opcion==="1")
                            <a href="" wire:click.prevent="inventar" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-file-invoice-dollar"></i> Registrar Respuesta
                            </a>
                        @endif
                        @if ($opcion==="2" && $observaciones)
                            <a href="" wire:click.prevent="inventar" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-file-invoice-dollar"></i> Registrar Respuesta
                            </a>
                        @endif
                    </div>


                @endif

                @if ($this->actual->academico>0 && !$this->actual->status_academico)
                    <hr class="w-8 h-8 mx-auto my-2 bg-gray-200 border-0 rounded md:my-2 dark:bg-gray-700">
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                        <div>
                            <h2 class="text-center font-semibold m-2">
                                Gestión pago acádemico.
                            </h2>
                            <a href="" wire:click.prevent="recibo" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-file-invoice-dollar"></i> Generar Recibo
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>

</div>
