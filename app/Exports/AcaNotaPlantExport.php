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

class AcaNotaPlantExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize
{
    use Exportable;

    private $id;
    private $xls;
    private $fileName = "NotasPlantilla.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($id, $xls)
    {
        $this->id=$id;
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
                    ->where('aprobo', 0)
                    ->orderBy('alumno')
                    ->get();
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {

        return $this->xls;
    }

    public function map($nota): array
    {
        return [
            $nota->nota_id,
            $nota->alumno_id,
            $nota->alumno,
            $nota->profesor_id,
            $nota->profesor,
            $nota->grupo_id,
            $nota->grupo,
            $nota->acumulado,
            $nota->observaciones,
            $nota->nota1,
            $nota->porcen1,
            $nota->nota2,
            $nota->porcen2,
            $nota->nota3,
            $nota->porcen3,
            $nota->nota4,
            $nota->porcen4,
            $nota->nota5,
            $nota->porcen5,
            $nota->nota6,
            $nota->porcen6,
            $nota->nota7,
            $nota->porcen7,
            $nota->nota8,
            $nota->porcen8,
            $nota->nota9,
            $nota->porcen9,
            $nota->nota10,
            $nota->porcen10,
        ];
    }

    public function columnFormats(): array
    {
        return [
            //'F' => 'dd/mm/yyyy',
        ];
    }

    /* public function drawings()
    {
        /* $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('PoliAndino');
        $drawing->setDescription('PoliAndino');
        $drawing->setPath(public_path('img/logo.jpeg'));
        $drawing->setHeight(70);
        $drawing->setCoordinates('A1');

        //return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Notas Plantilla');
        //$sheet->setCellValue('B2', 'LISTADO DE NOTAS A: '.now());
        //$sheet->mergeCells('B2:E2');
    } */
}
