<x-admin-layout>
    @push('title')
        Editar | Eliminar País
    @endpush
    <form action="{{route('admin.countries.update', $country)}}"
    method="POST"
    class="bg-white rounded-lg p-6 shadow-lg"
    >
        @csrf
        @method('PUT')
        <x-validation-errors class="mb-4"/>
        <div class="mb-4">
            <x-label class="mb-4 capitalize">
                Nombre del país:
            </x-label>
            <x-input
                name="name"
                class="w-full"
                placeholder="Escriba nombre del país."
                value="{{$country->name}}"
            />
        </div>
        <div class="flex justify-end">
            <x-danger-button class="mr-2" onclick="deleteCountry()">
                Eliminar
            </x-danger-button>
            <x-button>
                Actualizar País
            </x-button>
        </div>
    </form>
    <form action="{{route('admin.countries.destroy', $country)}}" method="POST" id="formDelete">
        @csrf
        @method('DELETE')
    </form>
    @push('js')
        <script>
            function deleteCountry(){
                let form=document.getElementById('formDelete');
                form.submit();
            }
        </script>
    @endpush
</x-admin-layout>
