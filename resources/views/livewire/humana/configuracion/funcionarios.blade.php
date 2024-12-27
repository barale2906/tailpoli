<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">
            FUNCIONARIOS
        </h1>
    </div>

    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">


            @include('includes.filtro')

        </div>
        <div class="relative overflow-x-auto">

            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >

                        </th><th scope="col" class="px-6 py-3" >
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Documento
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Edad
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Teléfono
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Correo Electrónico
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('cargo')">
                            Cargo
                            @if ($ordena != 'cargo')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('contrato')">
                            Fecha contrato vigente
                            @if ($ordena != 'contrato')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('salario')">
                            Salario
                            @if ($ordena != 'salario')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('eps')">
                            EPS
                            @if ($ordena != 'eps')
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
                    @foreach ($funcionarios as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    <a href="" wire:click.prevent="show({{$item->user_id}},1)" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <i class="fa-solid fa-users-gear"></i>
                                    </a>
                                </span>
                                <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                    <a href="" wire:click.prevent="show({{$item->user_id}},2)" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </span>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{$item->user->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->user->documento}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->user->perfil->edad}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->user->perfil->celular}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->user->email}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->cargo}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->contrato}}
                            </th>
                            <th scope="row" class="px-1 py-1 font-medium text-gray-900  dark:text-white capitalize">
                                $ {{number_format($item->salario, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->eps}}
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
                            <option value=3>3</option>
                            <option value=15>15</option>
                            <option value=20>20</option>
                            <option value=50>50</option>
                            <option value=100>100</option>
                        </select>
                    </label>
                </div>
                <div>
                    {{ $funcionarios->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_editing)
        <livewire:configuracion.user.perfil :elegido="$elegido" :perf="0"/>
    @endif

    @if ($is_actualizar)
        <livewire:humana.configuracion.actualizar :elegido="$elegido"/>
    @endif

    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    console.log(variable['name'])
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: variable['name'],
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
            });
        </script>
    @endpush

</div>
