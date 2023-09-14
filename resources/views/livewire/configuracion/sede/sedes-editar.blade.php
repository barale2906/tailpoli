<div>
    @if ($areas===0)
        <form wire:submit.prevent="edit">
            <div class="m-5">
                <h1 class="text-xl bg-green-100 mt-2 mb-3 p-3 rounded-full">
                    Esta sede se encuentra ubicada en la ciudad: <strong>{{$poblaName}}</strong>, del departamento: <strong>{{$deptoName}}</strong>, del país <strong>{{$paisName}}.</strong>
                </h1>
                <a href="#" wire:click.prevent="changeUbicacion()" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> Cambiar Ubicación
                </a>
                <a href="#" wire:click.prevent="areaShow()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> áreas
                </a>
            </div>
            @if ($cambia)
                <div>
                    <div class="mb-6">
                        <label for="pais" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>
                        <select wire:click="country($event.target.value)"  id="countries" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option >Elegir país...</option>
                            @foreach ($paises as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($pais && $states->count()>0)
                        <div class="mb-6">
                            <label for="depto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                            <select wire:click="depart($event.target.value)" id="depto" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option >Elegir departamento...</option>
                                @foreach ($states as $item)
                                    <option value={{$item->id}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if ($depto && $ciudades->count()>0)
                        <div class="mb-6">
                            <label for="pobla" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Población - Ciudad</label>
                            <select wire:click="poblacion($event.target.value)" id="pobla" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option >Elegir población - Ciudad...</option>
                                @foreach ($ciudades as $item)
                                    <option value={{$item->id}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            @endif

            @if ($pobla)
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de la sede</label>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="name">
                </div>
                @error('name')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror

                <div class="mb-6">
                    <label for="address class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección de la sede</label>
                    <input type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="dirección" wire:model.blur="address">
                </div>
                @error('address')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror

                <div class="mb-6">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono de la sede</label>
                    <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Teléfono de la sede" wire:model.blur="phone">
                </div>
                @error('phone')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror

                <div class="mb-6">
                    <label for="nit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIT de la sede</label>
                    <input type="text" id="nit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="nit">
                </div>
                @error('nit')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror

                <div class="mb-6">
                    <label for="portfolio_assistant_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Director(a) de la sede</label>
                    <input type="text" id="portfolio_assistant_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del director(a)" wire:model.blur="portfolio_assistant_name">
                </div>
                @error('portfolio_assistant_name')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror

                <div class="mb-6">
                    <label for="portfolio_assistant_phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono del director(a)</label>
                    <input type="text" id="portfolio_assistant_phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Teléfono(s) del director(a)" wire:model.blur="portfolio_assistant_phone">
                </div>
                @error('portfolio_assistant_phone')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror

                <div class="mb-6">
                    <label for="portfolio_assistant_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electrónico de la sede</label>
                    <input type="email" id="portfolio_assistant_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="correo electrónico" wire:model.blur="portfolio_assistant_email">
                </div>
                @error('portfolio_assistant_email')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <div class="mb-6">
                            <label for="start" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Horario de apertura</label>
                            <input type="time" id="start" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="start">
                        </div>
                        @error('start')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                    <div></div>
                    <div>
                        <div class="mb-6">
                            <label for="finish" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Horario de Cierre</label>
                            <input type="time" id="finish" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="finish">
                        </div>
                        @error('finish')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                    <div></div>
                </div>

                <button type="submit"
                class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                >
                    Editar Sede
                </button>
            @endif
            <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </form>
    @else
        <div class="m-5">
            <h1 class="text-xl bg-green-100 mt-2 mb-3 p-3 rounded-full">
                A continuación se muestran las áres de la sede: <strong class="capitalize">{{$name}}</strong>
            </h1>
            <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> volver a sedes
            </a>
        </div>
        <div class="grid grid-cols-2 gap-4 ">
            <div class="ring-4 p-2 rounded-lg">
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Listado de áreas:</h2>
                <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                    @foreach ($areasDefault as $item)
                        <li class="m-3">
                            <a href="#" wire:click.prevent="asignArea({{$item}})" >
                                {{$item->name}}
                                <span class="bg-green-100 text-green-800 text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    <i class="fa-solid fa-upload"></i>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="ring-4 p-2 rounded-lg">
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Áreas asignadas a esta sede:</h2>
                @if ($areaSede->count()>0)
                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        @foreach ($areaSede as $item)
                            <li class="m-3">
                                <a href="#" wire:click.prevent="eliminarArea({{$item}})" >
                                    {{$item->name}}
                                    <span class="bg-orange-100 text-orange-800 text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                        <i class="fa-solid fa-download"></i>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="capitalize text-center text-lg text-orange-500">¡No tiene áreas asignadas!</p>
                @endif
            </div>
        </div>
    @endif
</div>