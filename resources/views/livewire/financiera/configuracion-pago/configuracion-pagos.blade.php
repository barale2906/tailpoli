<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Configuraciones de Pago</h1>
    </div>

    @if ($is_modify)
        <div class="flex justify-end mb-4 ">
            @include('includes.filtro')
            @can('fi_configuracionpagoCrear')
                <a href="#" wire:click.prevent="$dispatch('created')" class="w-auto text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-plus"></i> crear Curso
                </a>
                <a href="#" wire:click.prevent="$dispatch('otros')" class="w-auto text-black bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-plus"></i> crear otro
                </a>
                <a href="#" wire:click.prevent="$dispatch('descuento')" class="w-auto text-black bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-tags"></i> Descuentos
                </a>
            @endcan
        </div>

        <nav class="dark:bg-gray-700 rounded-lg">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex items-center">
                    <ul class="flex flex-row font-medium mt-0 space-x-8 text-sm capitalize">
                        <li class="{{$lpstate ? 'bg-green-100': ''}} p-4">
                            <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline" aria-current="page">
                                Configuraciones por Curso
                            </a>
                        </li>
                        <li class="{{$otrostate ? 'bg-orange-100': ''}} p-4">
                            <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline">
                                Configuraciones otros conceptos
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @if ($lpstate)
            <div class="{{$lpstate ? 'bg-green-100': ''}} p-2">
                <div class="relative overflow-x-auto">
                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">

                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('id')">
                                    ID
                                    @if ($ordena != 'id')
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
                                    CIUDAD
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                                    CURSO
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('descripcion')">
                                    DESCRIPCIÓN
                                    @if ($ordena != 'descripcion')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor_curso')">
                                    VALOR CURSO
                                    @if ($ordena != 'valor_curso')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor_matricula')">
                                    VALOR MATRICULA
                                    @if ($ordena != 'valor_matricula')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('cuotas')">
                                    CUOTAS
                                    @if ($ordena != 'cuotas')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor_cuota')">
                                    VALOR CUOTA
                                    @if ($ordena != 'valor_cuota')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($configuraciones as $configuracione)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @can('fi_configuracionpagoEditar')
                                            @if ($configuracione->status===1)
                                                <a href="#" wire:click.prevent="show({{$configuracione}},{{0}})" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                                    <i class="fa-solid fa-marker"></i>
                                                </a>
                                            @endif
                                        @endcan
                                        @can('fi_configuracionpagoInactivar')
                                            <a href="#" wire:click.prevent="show({{$configuracione}},{{1}})" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                                <i class="fa-brands fa-creative-commons-sa"></i>
                                            </a>
                                        @endcan
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$configuracione->id}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$configuracione->sector->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$configuracione->curso->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$configuracione->descripcion}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        $ {{number_format($configuracione->valor_curso, 0, '.', ' ')}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        $ {{number_format($configuracione->valor_matricula, 0, '.', ' ')}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$configuracione->cuotas}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        $ {{number_format($configuracione->valor_cuota, 0, '.', ' ')}}
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
                            {{ $configuraciones->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($otrostate)
            <div class="relative overflow-x-auto {{$otrostate ? 'bg-orange-100': ''}} p-2">
                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('id')">
                                ID
                                @if ($ordena != 'id')
                                    <i class="fas fa-sort"></i>
                                @else
                                    @if ($ordenado=='ASC')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3">
                                CIUDAD
                            </th>
                            <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('descripcion')">
                                DESCRIPCIÓN
                                @if ($ordena != 'descripcion')
                                    <i class="fas fa-sort"></i>
                                @else
                                    @if ($ordenado=='ASC')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('inicia')">
                                Inicia
                                @if ($ordena != 'inicia')
                                    <i class="fas fa-sort"></i>
                                @else
                                    @if ($ordenado=='ASC')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('finaliza')">
                                Finaliza
                                @if ($ordena != 'finaliza')
                                    <i class="fas fa-sort"></i>
                                @else
                                    @if ($ordenado=='ASC')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($otros as $configuracione)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-orange-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$configuracione->id}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                    {{$configuracione->sector->name}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$configuracione->descripcion}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                    {{$configuracione->inicia}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                    {{$configuracione->finaliza}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @can('fi_configuracionpagoEditar')
                                        @if ($configuracione->status===1)
                                            <a href="#" wire:click.prevent="show({{$configuracione->id}},{{2}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                                <i class="fa-solid fa-marker"></i>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('fi_configuracionpagoInactivar')
                                        <a href="#" wire:click.prevent="show({{$configuracione}},{{3}})" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                        </a>
                                    @endcan
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-orange-100">
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
                        {{ $otros->links() }}
                    </div>
                </div>
            </div>
        @endif


    @endif

    @if ($is_creating)
        <livewire:financiera.configuracion-pago.configuracion-pagos-crear />
    @endif

    @if ($is_editing)
        <livewire:financiera.configuracion-pago.configuracion-pagos-editar :elegido="$elegido" />
    @endif

    @if ($is_deleting)
        <livewire:financiera.configuracion-pago.configuracion-pagos-inactivar :elegido="$elegido" />
    @endif

    @if ($is_otros)
        <livewire:financiera.configuracion-pago.configuracion-otros />
    @endif

    @if ($is_otrosEdit)
        <livewire:financiera.configuracion-pago.configuracion-otros-edit :elegido="$elegido"/>
    @endif

    @if ($is_otrosInactivar)
        <livewire:financiera.configuracion-pago.configuracion-otros-inactivar :elegido="$elegido"/>
    @endif

    @if ($is_descuentos)
        <livewire:financiera.descuento.descuentos />
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
