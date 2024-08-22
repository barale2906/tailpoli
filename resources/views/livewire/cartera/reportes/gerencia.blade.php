<div>
    <h1 class=" text-center uppercase font-extrabold text-3xl">
        Seleccione el año y mes que desea evaluar.
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
        <div></div>
        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

            <label for="anio" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Año</label>
            <select wire:model.live="anio" id="anio"
            class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                <option >Elegir Año</option>
                @foreach ($elegianos as $item)
                    <option value={{$item}}>{{$item}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
            <label for="mes" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Mes</label>
            <select wire:model.live="mes" id="mes"
            class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                <option >Elegir Mes</option>
                <option value=1>Enero</option>
                <option value=2>Febrero</option>
                <option value=3>Marzo</option>
                <option value=4>Abril</option>
                <option value=5>Mayo</option>
                <option value=6>Junio</option>
                <option value=7>Julio</option>
                <option value=8>Agosto</option>
                <option value=9>Septiembre</option>
                <option value=10>Octubre</option>
                <option value=11>Noviembre</option>
                <option value=12>Diciembre</option>
            </select>
        </div>
        <div></div>
    </div>
    @if ($is_reporte)
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">

        </div>
    @endif
</div>
