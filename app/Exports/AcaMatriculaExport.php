<?php

namespace App\Exports;

use App\Models\Academico\Matricula;use Illuminate\Contracts\Support\Responsable;
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

class AcaMatriculaExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $fileName = "Matriculas.xlsx";
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
        return Matricula::query()
                        ->with(['alumno', 'grupos', 'curso'])
                        ->when($this->buscamin, function($query){
                            return $query->where('status', true)
                                    ->where('metodo', 'like', "%".$this->buscamin."%")
                                    ->orWhere('valor', 'like', "%".$this->buscamin."%")
                                    ->orWhereHas('alumno', function($q){
                                        $q->where('name', 'like', "%".$this->buscamin."%")
                                            ->orWhere('documento', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('grupos', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('curso', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    });
                        })
                        ->orderBy('fecha_inicia', 'ASC')
                        ->get();
    }
    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Fecha Inicia',
            'Sede',
            'Curso',
            'Estudiante',
            '¿Cómo se entero?',
            'Conocimientos Previos',
            'valor',
            'Método de Pago',
            'Matriculo'
        ];
    }

    public function map($matricula): array
    {
        return [
            $matricula->fecha_inicia,
            $matricula->sede->name,
            $matricula->curso->name,
            $matricula->alumno->name,
            $matricula->medio,
            $matricula->nivel,
            $matricula->valor,
            $matricula->metodo,
            $matricula->creador->name
        ];
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
        $sheet->setTitle('matriculas');
        $sheet->setCellValue('B2', 'LISTADO DE MATRICULAS');
        $sheet->mergeCells('B2:H2');
    }
}
