<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
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

class AcaAsistenciaExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $id;
    private $asist;
    private $xls;
    private $fileName = "Asistencias.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($id, $xls, $asist)
    {
        $this->id=$id;
        $this->xls=$xls;
        $this->asist=$asist;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('asistencia_detalle')
                    ->where('asistencia_id', $this->id)
                    ->orderBy('alumno')
                    ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {

        return $this->xls;
    }

    public function map($asistencia): array
    {
        dd($this->asist);
        return [
            $asistencia->grupo,
            $asistencia->profesor,
            $asistencia->alumno,
            $asistencia->fecha1,
            $asistencia->fecha2,
            $asistencia->fecha3,
            $asistencia->fecha4,
            $asistencia->fecha5,
            $asistencia->fecha6,
            $asistencia->fecha7,
            $asistencia->fecha8,
            $asistencia->fecha9,
            $asistencia->fecha10,
            $asistencia->fecha11,
            $asistencia->fecha12,
            $asistencia->fecha13,
            $asistencia->fecha14,
            $asistencia->fecha15,
            $asistencia->fecha16,
            $asistencia->fecha17,
            $asistencia->fecha18,
            $asistencia->fecha19,
            $asistencia->fecha20,
            $asistencia->fecha21,
            $asistencia->fecha22,
            $asistencia->fecha23,
            $asistencia->fecha24,
            $asistencia->fecha25,
            $asistencia->fecha26,
            $asistencia->fecha27,
            $asistencia->fecha28,
            $asistencia->fecha29,
            $asistencia->fecha30,
            $asistencia->fecha31,
        ];
    }

    public function columnFormats(): array
    {
        return [
            //'F' => 'dd/mm/yyyy',
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
        $sheet->setTitle('Asistencias');
        $sheet->setCellValue('B2', 'LISTADO DE ASISTENCIAS A: '.now());
        $sheet->mergeCells('B2:E2');
    }
}
