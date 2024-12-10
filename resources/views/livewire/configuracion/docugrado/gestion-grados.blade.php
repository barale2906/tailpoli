<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Gestión Documentos de Grado</h1>
    </div>
    <div class="flex flex-wrap justify-end mb-4 ">
        @include('includes.filtro')
    </div>

@if ($filtroacta)
    <div class="inline-flex rounded-md shadow-sm" role="group">
        @foreach ($documentos as $value)
            <a href="/pdfs/docugrado/{{ $acta }}/{{$curso}}/{{ $value->id }}" target="_blank" >
                <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-blue-400 border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white uppercase">
                    <i class="fa-solid fa-print"></i>
                    imprimir {{$value->titulo}}
                </button>
            </a>
        @endforeach
    </div>
@endif

<livewire:configuracion.docugrado.cargaregistros />

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
                    timer: 1500
                })
            });
        });
    </script>
@endpush

</div>
