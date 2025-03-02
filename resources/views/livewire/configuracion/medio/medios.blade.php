<div>
    <h1 class="text-center text-xl font-bold">
        Gestión Medios de publicación y contacto
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-3">

        <div></div>
        <div class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <a href="" wire:click.prevent="" >

                <h5 class="mb-2 text-sm md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Medios
                </h5>
                @foreach ($medios as $item)
                    <p class="font-normal text-xs md:text-xl text-justify text-gray-700 dark:text-gray-400 capitalize">
                        <a href="" wire:click.prevent="actualizar({{$item->id}})">
                            {{$item->name}} - <span class=" text-xs">{{$estados[$item->status]}} </span>
                        </a>
                        - <a href="" wire:click.prevent="inactivar({{$item->id}})">
                            <i class="fa-solid fa-wrench"></i>
                        </a>
                    </p>
                @endforeach

            </a>
        </div>


        <div class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <a href="" wire:click.prevent="" >
                @if ($is_crear)
                    <h5 class="mb-2 text-sm md:text-2xl text-blue-900 font-bold tracking-tight dark:text-white">
                        Crear Medio
                    </h5>
                @else
                    <h5 class="mb-2 text-sm md:text-2xl text-green-900 font-bold tracking-tight dark:text-white">
                        Editar Medio
                    </h5>
                @endif

                <p class="font-normal text-xs md:text-xl text-justify text-gray-700 dark:text-gray-400">
                    <label for="name" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Nombre del medio</label>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="nombre medio" wire:model.live="name">

                </p>
                @if ($is_crear)
                    <a href="" wire:click.prevent="crear" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-5 capitalize">
                        <i class="fa-solid fa-plus"></i> Crear Medio
                    </a>
                @else
                    <a href="" wire:click.prevent="editar" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-5 capitalize">
                        <i class="fa-solid fa-pencil"></i> Editar Medio
                    </a>
                @endif

            </a>
        </div>


        <div></div>

    </div>

</div>
