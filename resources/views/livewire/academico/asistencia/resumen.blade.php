<div>
    @if ($actual)
        @foreach ($actual as $item)

            <livewire:academico.asistencia.detalle :asistencia="$item->asistencia_id" :grupo="$item->grupo" :detalle="$item->id" />
        @endforeach
    @else
        <h1 class=" uppercase">
            No tiene registros
        </h1>
    @endif
</div>
