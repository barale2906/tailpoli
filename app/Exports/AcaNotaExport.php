<?php

namespace App\Exports;

use App\Models\Academico\Nota;
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
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AcaNotaExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $id;
    private $encabezado;
    private $xls;
    private $fileName = "Notas.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($id, $encabezado, $xls)
    {
        $this->id=$id;
        $this->encabezado=$encabezado;
        $this->xls=$xls;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('notas_detalle')
                    ->where('status', true)
                    ->where('nota_id', $this->id)
                    ->orderBy('alumno')
                    ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        /* return [
            'Nombre',
            'Modulo',
            'Curso',
            'Inicia',
            'Finaliza',
            'Máximo Estudiantes',
            'Inscritos',
            'Profesor',
            'Fecha de Creación'
        ]; */

        return $this->xls;
    }

    public function map($nota): array
    {
        return [
            $nota->alumno_id,
            $nota->alumno,
            $nota->profesor_id,
            $nota->profesor,
            $nota->grupo,
            $nota->observaciones
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => 'dd/mm/yyyy',
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
        $sheet->setTitle('Notas');
        $sheet->setCellValue('B2', 'LISTADO DE NOTAS A: '.now());
        $sheet->mergeCells('B2:H2');
    }
}
