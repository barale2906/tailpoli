<?php

namespace App\Exports;

use App\Models\Academico\Control;
use App\Models\Configuracion\Estado;
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

class GraduacionExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $filtroSede;
    private $filtrocurso;
    private $filtroinicia;
    private $filtrogrado;
    private $estado_estudiante;
    private $estados;
    private $status;
    private $fileName = "Graduaciones.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct(
                                    $buscamin,
                                    $filtroSede,
                                    $filtrocurso,
                                    $filtroinicia,
                                    $filtrogrado,
                                    $estado_estudiante,
                                )
    {
        $this->buscamin=$buscamin;
        $this->filtroSede=$filtroSede;
        $this->filtrocurso=$filtrocurso;
        $this->filtroinicia=$filtroinicia;
        $this->filtrogrado=$filtrogrado;
        $this->estado_estudiante=$estado_estudiante;

        $this->estados=Estado::where('status', true)
                                ->orderBy('name', 'ASC')
                                ->get();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Control::whereNotIn('status_est',[11])
                        ->buscar($this->buscamin)
                        ->sede($this->filtroSede)
                        ->curso($this->filtrocurso)
                        ->inicia($this->filtroinicia)
                        ->grado($this->filtrogrado)
                        ->status($this->estado_estudiante)
                        ->orderBy('fecha_grado', 'DESC')
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
            'Documento',
            'correo electrónico',
            'celular',
            'Matricula',
            'Fecha Matricula',
            'Fecha Inicio',
            'Fecha Grado',
            'Programación',
            'Último Pago',
            'Última Asistencia',
            'Mora',
            'Kit',
            'Diploma',
            'Ceremonia',
            'Estatus Estudiante',
        ];
    }

    public function map($graduacion): array
    {
        foreach ($this->estados as $value) {
            if($value->id===intval($graduacion->status_est)){
                $this->status=$value->name;
            }
        }

        $celular=0;

        if($graduacion->estudiante->perfil){
            $celular=$graduacion->estudiante->perfil->celular;
        }

        return [
            $graduacion->estudiante->name,
            $graduacion->estudiante->documento,
            $graduacion->estudiante->email,
            $celular,
            $graduacion->matricula->id,
            $graduacion->matricula->created_at,
            $graduacion->inicia,
            $graduacion->fecha_grado,
            $graduacion->ciclo->name,
            $graduacion->ultimo_pago,
            $graduacion->ultima_asistencia,
            $graduacion->mora,
            $graduacion->overol,
            $graduacion->diploma,
            $graduacion->ceremonia,
            $this->status,
        ];

    }

    public function columnFormats(): array
    {
        return [
            'F' => 'dd/mm/yyyy',
            'G' => 'dd/mm/yyyy',
            'H' => 'dd/mm/yyyy',
            'j' => 'dd/mm/yyyy',
            'k' => 'dd/mm/yyyy',
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
        $sheet->setTitle('Graduaciones');
        $sheet->setCellValue('C2', 'LISTADO DE ALUMNOS CONTROL A: '.now());
        $sheet->mergeCells('C2:G2');
    }
}