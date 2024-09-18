<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">
            Cuentas centro de costo
        </h1>
    </div>

    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">
            @can('fi_cuentasCrear')
                <a href="#" wire:click.prevent="show(1)" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-plus"></i> crear
                </a>
            @endcan
        </div>
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('name')">
                            Nombre
                            @if ($ordena != 'name')
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('tipo')">
                            Tipo de movimiento
                            @if ($ordena != 'tipo')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Número de cuenta
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($centros as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    @can('fi_cuentasEditar')
                                        @if ($item->status)
                                            <a href="" wire:click.prevent="show({{2}},{{$item->id}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-blue-100 border border-blue-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">

                                                    <i class="fa-solid fa-marker"></i>

                                                </button>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('fi_cuentasInactivar')
                                        <a href="" wire:click.prevent="show({{3}},{{$item->id}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                            <button type="button" class="inline-flex rounded-e-lg items-center p-2 text-sm font-medium text-orange-900 bg-orange-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-orange-700 focus:z-10 focus:ring-2 focus:ring-orange-700 focus:text-orange-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-orange-500 dark:focus:text-white">
                                                <i class="fa-brands fa-creative-commons-sa"></i>
                                            </button>
                                        </a>
                                    @endcan
                                </div>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 capitalize dark:text-white">
                                {{$item->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->banco}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->tipo}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->numero_cuenta}}
                            </th>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($is_creating)
        <livewire:financiera.cuenta.cuenta-editar :accion="$accion" :elegido="$elegido" />
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
