<?php

namespace App\Exports;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
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

class AcaMatriculaExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $sede;
    private $sedecurso;
    private $curso;
    private $matriculo;
    private $comercial;
    private $estado;
    private $crea;
    private $inicia;
    private $fileName = "Matriculas.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin,$sede,$sedecurso,$curso,$matriculo,$comercial,$estado,$crea,$inicia)
    {
        $this->buscamin=$buscamin;
        $this->sede=$sede;
        $this->sedecurso=$sedecurso;
        $this->curso=$curso;
        $this->matriculo=$matriculo;
        $this->comercial=$comercial;
        $this->estado=$estado;
        $this->crea=$crea;
        $this->inicia=$inicia;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Matricula::buscar($this->buscamin)
                        ->sede($this->sede)
                        ->sedecurso($this->sedecurso)
                        ->curso($this->curso)
                        ->creador($this->matriculo)
                        ->comercial($this->comercial)
                        ->status($this->estado)
                        ->crea($this->crea)
                        ->inicia($this->inicia)
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
            'Fecha Matricula',
            'Fecha Inicia',
            'Sede matricula',
            'Sede donde toma el curso',
            'Curso',
            //'Programación',
            'Estudiante',
            'Documento',
            '¿Cómo se entero?',
            'Conocimientos Previos',
            'valor',
            'Matriculo',
            'Comercial',
            'Estado'
        ];
    }

    public function map($matricula): array
    {
        $estado="";
        if ($matricula->status) {
            $estado="Activa";
        } else {
            $estado="Inactiva";
        }
        $sede=Control::where('matricula_id',$matricula->id)->first();
        $nombre="";
        if($sede){
            $nombre=$sede->sede->name;
        }else{
            $nombre="";
        }

        return [
            $matricula->created_at,
            $matricula->fecha_inicia,
            $matricula->sede->name,
            $nombre,
            $matricula->curso->name,
            //$matricula->control->ciclo->name,
            $matricula->alumno->name,
            $matricula->alumno->documento,
            $matricula->medio,
            $matricula->nivel,
            $matricula->valor,
            $matricula->creador->name,
            $matricula->comercial->name,
            $estado
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
        $sheet->setCellValue('B2', 'LISTADO DE MATRICULAS A: '.now());
        $sheet->mergeCells('B2:H2');
    }
}
