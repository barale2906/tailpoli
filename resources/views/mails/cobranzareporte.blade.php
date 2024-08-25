<x-imprimir-layout>

    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                        <a href="" wire:navigate>
                            <img class="h-12 w-16 rounded-sm" src="{{asset('img/logomin.jpeg')}}" alt="{{env('APP_NAME')}}">
                        </a>

                    </th>
                    <th scope="col" class="px-6 py-3">
                        <h1 class="text-center  font-extrabold uppercase">POLIANDINO</h1>
                        <h2 class="text-center  font-extrabold uppercase">nit: 900656857-5</h2>
                        <h2 class="text-center  font-extrabold uppercase">INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL</h2>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        <dd class="text-gray-500 dark:text-gray-400">Curso:</dd>
                        <dt class="mb-2 text-xl font-extrabold">{{$cobro->curso->name}}</dt>
                    </th>
                </tr>
            </thead>
        </table>
        <p class="font-normal m-4 text-gray-700 dark:text-gray-400 text-justify">
            Reciba un cordial saludo estimado(a)
            <span class=" uppercase">
                {{$cobro->alumno->name}};
            </span>
        </p>
        <p class="font-normal m-4 text-gray-700 dark:text-gray-400 text-justify">
            Para <span class=" font-extrabold">
                INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL
            </span> es muy importante mantener a sus estudiantes informados acerca de sus obligaciones. Anexo encontrará información muy importante para ponerse al día con sus compromisos.
        </p>
        <p class="font-normal m-4 text-gray-700 dark:text-gray-400 text-justify">
            Durante los últimos días hemos venido informandole acerca de la mora que presenta el pago de su curso, el DÍA DE HOY nuestros sistemas se encargaran de realizar el reporte respectivo a las centrales de riesgo, ver documento anexo.<br>
            Le invitamos a que se comunique con nosotros para evitar este REPORTE NEGATIVO.
        </p>
        <p class="font-normal m-4 text-gray-700 dark:text-gray-400 text-justify">
            Anexo encontrará información muy importante para ponerse al día con sus compromisos.
        </p>
    </div>
</x-imprimir-layout>
