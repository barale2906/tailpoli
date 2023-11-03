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

class InvInventarioExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $fileName = "Inventarios.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin)
    {
        $this->buscamin=$buscamin;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventario::query()
                            ->with(['producto', 'almacen', 'user'])
                            ->when($this->buscamin, function($query){
                                return $query->where('status', true)
                                        ->where('descripcion', 'like', "%".$this->buscamin."%")
                                        ->orwhere('fecha_movimiento', 'like', "%".$this->buscamin."%")
                                        ->orWhereHas('producto', function($q){
                                            $q->where('name', 'like', "%".$this->buscamin."%");
                                        })
                                        ->orWhereHas('almacen', function($qu){
                                            $qu->where('name', 'like', "%".$this->buscamin."%");
                                        })
                                        ->orWhereHas('user', function($que){
                                            $que->where('name', 'like', "%".$this->buscamin."%");
                                        });
                            })
                            ->orderBy('id', 'DESC')
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
            'Tipo',
            'Ciudad',
            'Sede',
            'Almacén',
            'Producto',
            'Cantidad',
            'Saldo',
            'Precio',
            'Responsable del Movimiento',
            'Descripción'
        ];
    }

    public function map($inventario): array
    {
        return [
            $inventario->fecha_movimiento,
            $inventario->tipo ? "ENTRADA":"SALIDA",
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
            'C' => 'dd/mm/yyyy',
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
