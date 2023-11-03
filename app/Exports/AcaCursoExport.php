<?php

namespace App\Exports;

use App\Models\Academico\Curso;
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
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AcaCursoExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $fileName = "Cursos.xlsx";
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
        return Curso::where('name', 'like', "%".$this->buscamin."%")
                    ->orwhere('tipo', 'like', "%".$this->buscamin."%")
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Tipo',
            'Duración Horas',
            'Duración Meses',
            'Fecha de Creación'
        ];
    }

    public function map($curso): array
    {
        return [
            $curso->name,
            $curso->tipo,
            $curso->duracion_horas,
            $curso->duracion_meses,
            Date::dateTimeToExcel($curso->created_at)
        ];
    }

    public function columnFormats(): array
    {
        return [
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
        $sheet->setTitle('Cursos');
        $sheet->setCellValue('B2', 'LISTADO DE CURSOS A: '.now());
        $sheet->mergeCells('B2:D2');
    }
}
