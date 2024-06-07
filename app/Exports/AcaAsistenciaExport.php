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
    private $final=array();
    private $fileName = "Asistencias.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($id, $xls, $asist)
    {
        $this->id=$id;
        $this->xls=$xls;
        $this->asist=$asist;

        $this->carga();
    }

    public function carga(){

        foreach ($this->asist as $value) {
            $as=array();
            array_push($as, $value[2]);
            $this->individual($value,$as);
        }
    }

    public function individual($item,$arr){
        $as=array();
        $as=$arr;
        for ($i = 3; $i < count($item); $i++) {
            array_push($as, $item[$i]);
        }

        array_push($this->final, $as);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('asistencia_detalle')
                    ->where('asistencia_id', $this->id)
                    ->orderBy('alumno')
                    ->first();
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

        return $this->final;
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
