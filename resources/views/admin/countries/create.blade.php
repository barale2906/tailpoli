<x-admin-layout>
    <form action="{{route('admin.countries.store')}}"
    method="POST"
    class="bg-white rounded-lg p-6 shadow-lg"
    >
        @csrf
        <x-validation-errors class="mb-4"/>
        <div class="mb-4">
            <x-label class="mb-4 capitalize">
                Nombre del país:
            </x-label>
            <x-input
                name="name"
                class="w-full"
                placeholder="Escriba nombre del país."
            />
        </div>
        <div class="flex justify-end">
            <x-button>
                Crear
            </x-button>
        </div>
    </form>
</x-admin-layout>
