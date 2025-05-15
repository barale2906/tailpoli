<?php

namespace App\Exports;

use App\Models\Inventario\Inventario;
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

class InvInventarioPendExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{use Exportable;

    private $buscamin;
    private $fileName = "Inventario_pendiente.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventario::join('users', 'inventarios.compra_id', '=', 'users.id')
                            ->where('inventarios.tipo', 2)
                            ->where('inventarios.entregado', false)
                            ->orderBy('inventarios.id', 'DESC')
                            ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Fecha Movimiento',
            'Ciudad',
            'Sede',
            'Alumno',
            'Almacén',
            'Producto',
            'Cantidad',
            'Precio',
            'Responsable del Movimiento',
            'Descripción'
        ];
    }

    public function map($inventario): array
    {
        return [
            $inventario->fecha_movimiento,
            $inventario->almacen->sede->sector->name,
            $inventario->almacen->sede->name,
            $inventario->name,
            $inventario->almacen->name,
            $inventario->producto->name,
            $inventario->cantidad,
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
        $sheet->setCellValue('C2', 'PENDIENTES A: '.now());
        $sheet->mergeCells('C2:I2');
    }
}
