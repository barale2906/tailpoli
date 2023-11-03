<?php

namespace App\Exports;

use App\Models\Financiera\CierreCaja;
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

class FinCierreCajaExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $fileName = "Cierres.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CierreCaja::orderBy('id', 'DESC')
                            ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'N°',
            'Fecha',
            'Sede',
            'Cajero',
            'Valor',
            'Valor Reportado - Cajero - Efectivo',
            'Valor pensiones',
            'Valor efectivo',
            'Valor tarjeta',
            'Valor cheque',
            'Valor consignación',
            'Valor Total Otros',
            'Valor Efectivo Otros',
            'Valor tarjeta Otros',
            'Valor cheque Otros',
            'Valor consignación Otros',
            'Observaciones'
        ];
    }

    public function map($cierre): array
    {
        return [
            $cierre->id,
            $cierre->fecha_cierre,
            $cierre->sede->name,
            $cierre->cajero->name,
            $cierre->valor_total,
            $cierre->valor_reportado,
            $cierre->valor_pensiones,
            $cierre->valor_efectivo,
            $cierre->valor_tarjeta,
            $cierre->valor_cheque,
            $cierre->valor_consignacion,
            $cierre->valor_otros,
            $cierre->valor_efectivo_o,
            $cierre->valor_tarjeta_o,
            $cierre->valor_cheque_o,
            $cierre->valor_consignacion_o,
            $cierre->observaciones
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
        $sheet->setTitle('Cierres');
        $sheet->setCellValue('C2', 'LISTADO DE CIERRES A: '.now());
        $sheet->mergeCells('C2:P2');
    }
}
