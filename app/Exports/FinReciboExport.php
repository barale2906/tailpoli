<?php

namespace App\Exports;

use App\Models\Financiera\ReciboPago;
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

class FinReciboExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $filtrosede;
    private $filtrocrea;
    private $fileName = "Recibos.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin,$filtrosede,$filtrocrea)
    {
        $this->buscamin=$buscamin;
        $this->filtrosede=$filtrosede;
        $this->filtrocrea=$filtrocrea;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReciboPago::where('origen', 1)
                            ->buscar($this->buscamin)
                            ->sede($this->filtroSede)
                            ->crea($this->filtrocrea)
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
            'N°',
            'Fecha',
            'Alumno',
            'Sede',
            'Valor',
            'Descuento',
            'Medio',
            'Cajero',
            'Observaciones'
        ];
    }

    public function map($recibo): array
    {
        return [
            $recibo->id,
            $recibo->fecha,
            $recibo->paga->name,
            $recibo->sede->name,
            $recibo->valor_total,
            $recibo->descuento,
            $recibo->medio,
            $recibo->creador->name,
            $recibo->observaciones,
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
        $sheet->setTitle('Recibos');
        $sheet->setCellValue('C2', 'LISTADO DE RECIBOS A: '.now());
        $sheet->mergeCells('C2:G2');
    }
}
