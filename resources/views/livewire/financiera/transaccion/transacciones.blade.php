<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">
            transacciones por identificar
        </h1>
    </div>

    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">
            @include('includes.filtro')
            @can('fi_export')
                <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-file-excel fa-beat"></i>
                </a>
            @endcan
        </div>
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" ></th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha')">
                            Fecha de Creación
                            @if ($ordena != 'fecha')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('academico')">
                            Acádemico
                            @if ($ordena != 'academico')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('inventario')">
                            Otros
                            @if ($ordena != 'inventario')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('observaciones')">
                            Observaciones
                            @if ($ordena != 'observaciones')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>

                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_transaccion')">
                            Fecha Transacción
                            @if ($ordena != 'fecha_transaccion')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>

                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('banco')">
                            Banco
                            @if ($ordena != 'banco')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Creador
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transacciones as $transaccione)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">

                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                @if ($transaccione->status<4)
                                    @can('fi_transaccionesEditar')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                            <a href="" wire:click.prevent="show({{$transaccione->id}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i> - {{$transaccione->id}}
                                            </a>
                                        </span>
                                    @endcan
                                @else
                                    <a href="{{Storage::url($transaccione->ruta)}}" target="_blank">
                                        <button type="button" class="px-4 py-2 text-xs font-medium text-gray-900 bg-blue-150 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            <i class="fa-solid fa-magnifying-glass"></i> - {{$transaccione->id}}
                                        </button>
                                    </a>
                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$transaccione->fecha}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$transaccione->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$transaccione->user->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white text-right">
                                $ {{number_format($transaccione->academico, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white text-right">
                                $ {{number_format($transaccione->inventario, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->observaciones}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->fecha_transaccion}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->banco}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->creador->name}}
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
                    {{ $transacciones->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_editing)
        <livewire:financiera.transaccion.transaccion-editar :elegido="$elegido" />
    @endif

    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    console.log(variable['name'])
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: variable['name'],
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
            });
        </script>
    @endpush
</div>
