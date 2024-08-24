<div>
    @if ($actual)
        @foreach ($actual as $item)
            <livewire:academico.nota.detalle :nota="$item->id"/>
        @endforeach
    @else
        <h1 class=" uppercase">
            No tiene registros
        </h1>
    @endif
</div>

