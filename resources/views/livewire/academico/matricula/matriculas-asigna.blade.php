<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4">
        <div></div>
        <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{$matricula->alumno->name}}</h5>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                {{$matricula->curso->name}}
            </p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <a href="" wire:click.prevent="$parent.show({{$matricula}},{{2}})" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                    <i class="fa-solid fa-people-roof fa-beat mr-3"></i>
                    <div class="text-left">
                        <div class="mb-1 text-xs"> Asignarle:</div>
                        <div class="-mt-1 font-sans text-sm font-semibold"> GRUPOS</div>
                    </div>
                </a>
                <a href="/financiera/recibopagos" class="w-full sm:w-auto bg-orange-800 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-orange-700 dark:hover:bg-orange-600 dark:focus:ring-orange-700">
                    <i class="fa-solid fa-chart-line fa-beat mr-3"></i>
                    <div class="text-left">
                        <div class="mb-1 text-xs"> Generar</div>
                        <div class="-mt-1 font-sans text-sm font-semibold"> RECIBO DE CAJA</div>
                    </div>
                </a>
            </div>
        </div>
        <div></div>
    </div>
</div>
