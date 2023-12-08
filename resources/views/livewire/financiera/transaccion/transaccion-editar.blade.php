<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mb-4">

        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="{{asset($this->actual->ruta)}}" />
                {{-- <img class="rounded-t-lg" src="{{$this->url}}" alt="{{$this->url}}" /> --}}
            </a>
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
                        Inventario: $ {{number_format($this->actual->inventario, 0, '.', ' ')}}
                    </p>
                @endif
                <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
                    Creado por: {{$this->actual->creador->name}}
                </p>
                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>

            </div>
        </div>
        @if ($is_recibo)
            <div>
                <livewire:financiera.recibo-pago.recibos-pago-crear :ruta="$ruta" :elegido="$this->actual->id"/>
            </div>
        @else
            <div>
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

                    @if ($opcion==="1")
                        <a href="" wire:click.prevent="inventar" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Registrar Respuesta
                        </a>
                    @endif
                    @if ($opcion==="2" && $observaciones)
                        <a href="" wire:click.prevent="inventar" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Registrar Respuesta
                        </a>
                    @endif

                @endif

                @if ($this->actual->academico>0 && !$this->actual->status_academico)
                    <a href="" wire:click.prevent="recibo" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Generar Recibo
                    </a>
                @endif
            </div>
        @endif

    </div>

</div>
