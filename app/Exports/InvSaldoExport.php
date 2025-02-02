<?php

namespace App\Exports;
use App\Models\Inventario\Inventario;
use App\Traits\CrtStatusTrait;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvSaldoExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;
    use CrtStatusTrait;

    private $buscamin;
    private $filtrocrea;
    private $valorFiltrotipo;
    private $filtrosaldo;
    private $filtroalmacen;
    private $fileName = "InvenSaldo.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct(/* $buscamin,$filtrocrea,$valorFiltrotipo,$filtroalmacen,$filtrosaldo */)
    {
        /* $this->buscamin=$buscamin;
        $this->filtrocrea=$filtrocrea;
        $this->valorFiltrotipo=$valorFiltrotipo;
        $this->filtroalmacen=$filtroalmacen;
        $this->filtrosaldo=$filtrosaldo; */
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $caso=Inventario::where('status',true)->get();
        return  $caso;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Fecha Movimiento',
            //'Tipo (1 sálida, 2 entrada, 3 pendiente, 4 traslado)',
            'Tipo',
            'Ciudad',
            'Sede',
            'Almacén',
            'Producto',
            'Cantidad',
            'Saldo con este movimiento (si el campo esta vacio su valor es cero)',
            'Precio (si el campo esta vacio su valor es cero)',
            'Responsable del Movimiento',
            'Descripción'
        ];
    }

    public function map($inventario): array
    {
        $tipo=$this->statusInventipo[$inventario->tipo];

        if($inventario->saldo===0){
            $saldo=0;
        }else{
            $saldo=$inventario->saldo;
        }

        if($inventario->precio===0){
            $precio=0;
        }else{
            $precio=$inventario->precio;
        }

        return [
            $inventario->fecha_movimiento,
            //$inventario->tipo+1,// ? "ENTRADA":"SALIDA",
            $tipo,
            $inventario->almacen->sede->sector->name,
            $inventario->almacen->sede->name,
            $inventario->almacen->name,
            $inventario->producto->name,
            $inventario->cantidad,
            $inventario->saldo,
            $inventario->precio,
            $inventario->user->name,
            $inventario->descripcion
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => 'dd/mm/yyyy',
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('PoliAndino');
        $drawing->setDescription('PoliAndino');
        $drawing->setPath(public_path('img/logo.jpeg'));
        $drawing->setHeight(70);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Inventarios');
        $sheet->setCellValue('C2', 'MOVIMIENTOS DE INVENTARIO A: '.now());
        $sheet->mergeCells('C2:J2');
    }
}
