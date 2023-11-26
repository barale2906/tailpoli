<div>
    <h1 class="text-2xl text-center">
        Bienvenido(a): <span class="font-extrabold uppercase">{{Auth::user()->name}}</span>, estos son los datos clave para tu formación en
        <strong class="font-extrabold uppercase">
            {{config('instituto.nombre_empresa')}}
        </strong>.

    </h1>

    @if ($is_modify)
        @foreach ($control as $item)
            <section class="bg-cyan-50 dark:bg-gray-900 rounded-xl">
                <div class="py-2 px-1 mx-auto max-w-screen-xl lg:py-4 grid lg:grid-cols-2 gap-2 lg:gap-2">
                    <div class="flex flex-col justify-center">
                        <h1 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 dark:text-white uppercase">
                            Curso: {{$item->matricula->curso->name}}
                        </h1>
                        <h2 class="md:text-lg font-bold text-gray-900 dark:text-white">
                            Fecha de Inicio: {{$item->inicia}}
                        </h2>
                        <h2 class="md:text-lg font-extrabold text-gray-900 dark:text-white uppercase">
                            Cartera: $ {{number_format($cartera->sum('saldo'), 0, '.', '.')}}
                        </h2>
                        <p class="mb-6 md:text-xs font-normal text-justify text-gray-500 dark:text-gray-400">
                            Observaciones: {{$item->observaciones}}
                        </p>
                    </div>
                    <div>
                        <div class="w-full lg:max-w-xl p-2 space-y-8 sm:p-2 bg-white rounded-lg shadow-xl dark:bg-gray-800">

                            <div class="sm:grid-cols-1 md:grid-cols-2 gap-2">
                                <div>
                                    <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha último Pago:</label>
                                    <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                        {{$item->ultimo_pago}}
                                    </h2>
                                </div>
                                <div>
                                    <label for="sede" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha última Asistencia:</label>
                                    <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                        {{$item->ultima_asistencia}}
                                    </h2>
                                </div>
                                <div>
                                    <label for="sede" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tienes Kit:</label>
                                    <h2 class="font-bold text-gray-900 dark:text-white uppercase">
                                        {{$item->overol}},
                                        @if ($item->overol!=="si")
                                            Recuerda adquirir tu kit.
                                        @endif
                                    </h2>
                                </div>
                            </div>

                            <h5 class="text-semibold md:text-lg sm:text-sm capitalize m-3">Modulos a los que estas inscrito(a):</h5>
                            @foreach ($item->ciclo->ciclogrupos as $iteme)

                                <div class="block max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                    <h5 class="text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                        {{$iteme->grupo->modulo->name}}
                                    </h5>
                                    <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                        Grupo: {{$iteme->grupo->name}}
                                    </p>
                                    <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize mb-2">
                                        Profesor: {{$iteme->grupo->profesor->name}}
                                    </p>
                                    <a href="" wire:click.prevent="notas({{$iteme->id}},{{$iteme->grupo->profesor->id}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-5 capitalize">
                                        <i class="fa-solid fa-magnifying-glass"></i> Notas
                                    </a>
                                    <a href="" wire:click.prevent="asistencia({{$iteme->id}},{{$iteme->grupo->profesor->id}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-5 capitalize">
                                        <i class="fa-regular fa-calendar-days"></i> Asistencia
                                    </a>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        <div class="relative overflow-x-auto m-1 text-center ring ring-black mt-6 mb-6">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase font-extrabold bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-xs">
                            concepto
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs">
                            fecha de pago
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs">
                            valor
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs">
                            Días de retraso
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs">
                            Saldo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartera as $item)
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-3 py-1 text-justify text-gray-900 text-xs  dark:text-white capitalize">
                                {{$item->concepto}}
                            </th>
                            <th scope="row" class="px-3 py-1 text-center text-gray-900 text-xs  dark:text-white capitalize">
                                {{$item->fecha_pago}}
                            </th>
                            <th scope="row" class="px-3 py-1 text-right text-gray-900 text-xs  dark:text-white capitalize">
                                $ {{number_format($item->valor, 0, '.', '.')}}
                            </th>
                            <th scope="row" class="px-3 py-1 text-right text-red-700 text-xs  dark:text-white uppercase">
                                @if ($item->fecha_pago < $fecha)
                                    @php
                                        $fecha1 = date_create($item->fecha_pago);
                                        $dias = date_diff($fecha1, $fecha)->format('%R%a');
                                    @endphp
                                    {{$dias}} días
                                @endif
                            </th>
                            <th scope="row" class="px-3 py-1 text-right text-gray-900 text-xs  dark:text-white capitalize">
                                $ {{number_format($item->saldo, 0, '.', '.')}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($is_notas)
        <livewire:academico.nota.individual :nota="$nota" :alumno_id="$alumno_id" :crt="true"/>
    @endif

    @if ($is_asistencia)
        <livewire:academico.asistencia.individual :elegido="$nota" :alumno_id="$alumno_id" :crt="true"/>
    @endif

    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    console.log(variable['name'])
                    Swal.fire({
                        position: 'top-end',
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
