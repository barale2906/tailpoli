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


class AcaGestExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $estado;
    private $sede;
    private $fileName = "EstadoEstudiantes.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;
    private $estados;

    public function __construct($buscamin,$sede,$estado)
    {
        $this->buscamin=$buscamin;
        $this->sede=$sede;
        $this->estado=$estado;
        $this->estados=Estado::where('status', true)
                                ->orderBy('name', 'ASC')
                                ->get();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Control::estado($this->estado)
                        ->buscar($this->buscamin)
                        ->sede($this->sede)
                        ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Fecha Inicio',
            'Sede',
            'Curso',
            'Programación',
            'Estudiante',
            'Documento',
            'Último pago',
            'Última asistencia',
            'Mora',
            'Kit',
            'Estatus estudiante'
        ];
    }

    public function map($activo): array
    {
        foreach ($this->estados as $value) {
            if($activo->status_est===$value->id){
                $estatus_est=$value->name;
            }
        }
        return [
            $activo->inicia,
            $activo->sede->name,
            $activo->matricula->curso->name,
            $activo->ciclo->name,
            $activo->estudiante->name,
            $activo->estudiante->documento,
            $activo->ultimo_pago,
            $activo->ultima_asistencia,
            $activo->mora,
            $activo->overol,
            $estatus_est
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
        $sheet->setTitle('estado estudiantes');
        $sheet->setCellValue('B2', 'ESTADO DE ESTUDIANTES A: '.now());
        $sheet->mergeCells('B2:H2');
    }
}
