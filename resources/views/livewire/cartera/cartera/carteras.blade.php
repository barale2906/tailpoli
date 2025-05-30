<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Cartera</h1>
    </div>

    @if ($is_modify)

        <livewire:cartera.cartera.consolidado />
        <div class="flex justify-end mb-4 ">
            @include('includes.filtro')
            @can('ca_export')
                <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-file-excel fa-beat"></i>
                </a>
            @endcan
        </div>
        <div class="relative overflow-x-auto">
            <h2 class=" text-center font-semibold text-lg">
                Cartera según parámetros: $ {{number_format($total, 0, ',', '.')}} para los estudiantes con estado:
                @foreach ($elegidos as $item)
                    <span class=" capitalize font-extrabold">
                        {{$item->name}},
                    </span>
                @endforeach
            </h2>
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th>

                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Estudiante
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('saldo')">
                            Saldo
                            @if ($ordena != 'saldo')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('original')">
                            Inicial
                            @if ($ordena != 'original')
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
                    @foreach ($carteras as $cartera)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th>
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-blue-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <a href="" wire:click.prevent="show({{$cartera->matricula_id}},{{0}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <i class="fa-regular fa-lightbulb"></i> Detalle
                                        </a>
                                    </button>
                                    @can('ca_convenio')
                                        <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-cyan-100 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            <a href="#" wire:click.prevent="show({{$cartera->matricula_id}},{{1}})" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                                <i class="fa-solid fa-plus"></i> Acuerdo de pago
                                            </a>
                                        </button>
                                    @endcan
                                </div>

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$cartera->responsable->documento}} - {{$cartera->responsable->name}} - {{$cartera->matricula->curso->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  text-right dark:text-white capitalize">
                                $ {{number_format($cartera->saldo, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  text-right dark:text-white capitalize">
                                $ {{number_format($cartera->original, 0, ',', '.')}}
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
                            <option value=10>10</option>
                            <option value=15>15</option>
                            <option value=20>20</option>
                            <option value=50>50</option>
                            <option value=100>100</option>
                        </select>
                    </label>
                </div>
                <div>
                    {{ $carteras->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($is_creating)
        <livewire:cartera.cartera.convenio :id="$alumno"/>
    @endif

    @if ($is_cartera)
        <livewire:cartera.cartera.detalle :alumno="$alumno" />
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
                        timer: 2000
                    })
                });
            });
        </script>
    @endpush
</div>
