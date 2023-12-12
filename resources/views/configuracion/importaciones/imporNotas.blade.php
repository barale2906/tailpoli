<x-admin-layout>
    @push('title')
        Importar Notas
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" enctype="multipart/form-data" class="bg-white rounded p-8 shadow">
                @csrf
                <div>
                    <h1 class="text-2xl font-semibold mb-4">
                        Por favor seleccione el archivo a importar
                    </h1>
                    <input type="file" name="file">
                </div>
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Cargar
                </button>

            </form>
        </div>
    </div>

</x-admin-layout>
