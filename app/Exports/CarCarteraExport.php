<?php

namespace App\Exports;

use App\Models\Financiera\Cartera;
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

class CarCarteraExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $periodo;
    private $fileName = "Carteras.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin, $periodo)
    {
        $this->buscamin=$buscamin;
        $this->periodo=$periodo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cartera::where('status',true)
                        ->buscar($this->buscamin)
                        ->vencido($this->periodo)
                        ->orderBy('fecha_pago', 'ASC')
                        ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Estudiante',
            'Curso',
            'Concepto',
            'Fecha Programada',
            'Fecha Real de Pago',
            'Valor Inicial',
            'Saldo',
            'Observaciones'
        ];
    }

    public function map($cartera): array
    {
        return [
            $cartera->responsable->name,
            $cartera->matricula->curso->name,
            $cartera->concepto,
            $cartera->fecha_pago,
            $cartera->fecha_real,
            $cartera->valor,
            $cartera->saldo,
            $cartera->observaciones
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => 'dd/mm/yyyy',
            'E' => 'dd/mm/yyyy',
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
        $sheet->setTitle('Carteras');
        $sheet->setCellValue('B2', 'LISTADO DE CARTERAS A: '.now());
        $sheet->mergeCells('B2:G2');
    }
}
