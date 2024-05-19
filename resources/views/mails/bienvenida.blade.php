<x-imprimir-layout>

    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                        <a href="" wire:navigate>
                            <img class="h-12 w-16 rounded-sm" src="{{asset('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
                        </a>

                    </th>
                    <th scope="col" class="px-6 py-3">
                        <h1 class="text-center  font-extrabold uppercase">POLIANDINO</h1>
                        <h2 class="text-center  font-extrabold uppercase">nit: 900656857-5</h2>
                        <h2 class="text-center  font-extrabold uppercase">INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL</h2>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        <dd class="text-gray-500 dark:text-gray-400">Curso:</dd>
                        <dt class="mb-2 text-xl font-extrabold">{{$matricula->curso->name}}</dt>
                    </th>
                </tr>
            </thead>
        </table>
        <p class="font-normal m-4 text-gray-700 dark:text-gray-400">
            Te damos la bienvenida a nuestra institución educativa, anexo a este correo encontraras el carnet que te acredita como estudiante de <span class=" font-extrabold">
                INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL
            </span>
        </p>
    </div>
</x-imprimir-layout>
