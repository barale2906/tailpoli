<div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 m-3">
    <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab">
        <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto sm:grid-cols-3 xl:grid-cols-4 dark:text-white sm:p-8">

            <div class="flex flex-col items-center justify-center mb-4">
                <dt class="mb-2 text-3xl font-extrabold text-cyan-700">$ {{number_format($cobrohoy, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400">HOY</dd>
            </div>
            <div class="flex flex-col items-center justify-center mb-2">
                <dt class="mb-2 text-3xl font-extrabold text-red-900">$ {{number_format($sesentaMen, 0, ',', '.')}} </dt>
                <dd class="text-gray-500 dark:text-gray-400">Vencido mas de 60 días</dd>
            </div>
            <div class="flex flex-col items-center justify-center mb-2">
                <dt class="mb-2 text-3xl font-extrabold text-red-700">$ {{number_format($treSenMen, 0, ',', '.')}} </dt>
                <dd class="text-gray-500 dark:text-gray-400">Vencido 31 - 60 días</dd>
            </div>
            <div class="flex flex-col items-center justify-center mb-4">
                <dt class="mb-2 text-3xl font-extrabold text-red-500">$ - {{number_format($treMen, 0, ',', '.')}} </dt>
                <dd class="text-gray-500 dark:text-gray-400">Vencido menos 30 días</dd>
            </div>
            <div class="flex flex-col items-center justify-center mb-4">
                <dt class="mb-2 text-3xl font-extrabold text-cyan-700">$ {{number_format($treMas, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Menos de 30 días</dd>
            </div>
            <div class="flex flex-col items-center justify-center mb-4">
                <dt class="mb-2 text-3xl font-extrabold text-cyan-500">$ {{number_format($treSenMas, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400">31 - 60 días</dd>
            </div>
            <div class="flex flex-col items-center justify-center mb-4">
                <dt class="mb-2 text-3xl font-extrabold text-cyan-200">$ {{number_format($sesentaMas, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400">Más de 60 días</dd>
            </div>
        </dl>
    </div>
</div>

