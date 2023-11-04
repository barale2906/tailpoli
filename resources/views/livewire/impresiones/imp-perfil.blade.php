<div>
    @push('title')
        {{$user->name}}
    @endpush

    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        @if ($user->profile_photo_path)
                            <a href="/academico/estudiantes" wire:navigate>
                                <img class="h-16 w-18 rounded-sm" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" >
                            </a>
                        @else
                            <a href="/academico/estudiantes" wire:navigate>
                                <img class="h-16 w-18 rounded-sm" src="{{asset('img/logo.jpeg')}}" alt="{{ $user->name }}">
                            </a>
                        @endif
                    </th>
                    <th scope="col" colspan="3" class="px-6 py-3">
                        <h1 class="text-center text-5xl  font-extrabold uppercase">{{$user->name}}</h1>
                        <h2 class="text-center  font-extrabold capitalize">(Perfil del Usuario - Estudiante)</h2>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-justify text-xl uppercase">
                        DATOS DE ORIGEN
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        País: {{$user->perfil->country->name}}  Departamento - Región: {{$user->perfil->state->name}} - {{$user->perfil->sector->name}}
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-justify text-xl uppercase">
                        DATOS DE IDENTIFICACIÓN
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        <h2 class="capitalize">Documento de Identificación: {{$user->perfil->tipo_documento}} Nro. {{number_format($user->documento, 0, '.', '.')}}</h2>
                        <h2>Lugar y fecha de expedición: {{$user->perfil->fecha_documento}} - {{$user->perfil->lugar_expedicion}}</h2>
                        <h2>Fecha de nacimiento: {{$user->perfil->fecha_nacimiento}}</h2>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-justify text-xl uppercase">
                        DATOS DE RESIDENCIA
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        <h2 class="capitalize">Dirección: {{$user->perfil->direccion}} Barrio: {{$user->perfil->barrio}}</h2>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-justify text-xl uppercase">
                        DATOS DE CONTACTO
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        <h2 class="capitalize">Teléfono Móvil: {{$user->perfil->celular}}</h2>
                        <h2 class="capitalize">Teléfono Whats App: {{$user->perfil->fijo}} - Teléfono Fijo: {{$user->perfil->fijo}}</h2>
                        <h2 class="capitalize">Persona Contacto: {{$user->perfil->contacto}}</h2>
                        <h2 class="capitalize">teléfono Contacto: {{$user->perfil->telefono_contacto}}</h2>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-justify text-xl uppercase">
                        DATOS SOCIALES
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">

                        <h2 class="capitalize">Estrato Social: {{$user->perfil->estrato}} - Nivel educativo: {{$user->perfil->nivel_educativo}}</h2>
                        <h2 class="capitalize">Ocupación: {{$user->perfil->ocupacion}} - Empresa: {{$user->perfil->empresa_usuario}}</h2>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-justify text-xl uppercase">
                        SALUD Y OTROS DATOS
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        <h2 class="capitalize">
                            Régimen de Salud: {{$user->perfil->regimenSalud->name}} -
                            RH: {{$user->perfil->rh_usuario}}
                        </h2>
                        <h2 class="capitalize">
                            Discapacidad: {{$user->perfil->discapacidad}} -
                            Enfermedad: {{$user->perfil->enfermedad}}
                        </h2>
                        <h2 class="capitalize">
                            Género: {{$user->perfil->genero}} -
                            Estado civil: {{$user->perfil->estado_civil}} -
                            Talla: {{$user->perfil->talla}} -
                            Calzado: {{$user->perfil->calzado}}
                        </h2>
                        <h2 class="capitalize">
                            Permiso de imagen: {{$user->perfil->autoriza_imagen}}
                        </h2>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>


</div>
