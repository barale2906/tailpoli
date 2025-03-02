<?php

namespace App\Exports;

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

    private $totales;
    private $almacenes;
    private $ids;
    private $fileName = "InvenSaldo.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($totales,$almacenes,$ids)
    {
        $this->totales=$totales;
        $this->almacenes=$almacenes;
        $this->ids=$ids;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->totales);
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        $alma=[];
        array_push($alma,'Producto');
        foreach ($this->almacenes as $value) {
            array_push($alma,$value->name);
        }
        return $alma;
    }

    public function map($total): array
    {
        $row=[];

        array_push($row,$total['producto']);

        for ($i=0; $i < $this->almacenes->count(); $i++) {
            $almaid=$this->almacenes[$i]->id;

            if(isset($total[$almaid])){
                array_push($row,$total[$almaid]);
            }
        }

        return $row;
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
