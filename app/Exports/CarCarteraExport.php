<?php

namespace App\Exports;

use App\Models\Financiera\Cartera;
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

class CarCarteraExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $periodo;
    private $ciudad;
    private $sede;
    private $estestudiante;
    private $estcartera;
    private $fileName = "Carteras.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin,$periodo,$ciudad,$sede,$estestudiante,$estcartera)
    {
        $this->buscamin=$buscamin;
        $this->periodo=$periodo;
        $this->ciudad=$ciudad;
        $this->sede=$sede;
        $this->estestudiante=$estestudiante;
        $this->estcartera=$estcartera;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cartera::buscar($this->buscamin)
                        ->vencido($this->periodo)
                        ->sede($this->sede)
                        ->ciudad($this->ciudad)
                        ->status($this->estestudiante)
                        ->statcar($this->estcartera)
                        ->orderBy('matricula_id', 'ASC')
                        ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Tipo identificación',
            'Número identificación',
            'Nombre Estudiante',
            'Correo Electrónico',
            'Teléfono',
            'Matricula',
            'Fecha matricula',
            'Curso',
            'Fecha Programada',
            'Fecha Real de Pago',
            'Valor Inicial',
            'Valor pagado',
            'Saldo',
            'Concepto',
            'Ciudad',
            'Sede',
            'Observaciones',
            'Estado Estudiante',
            'Estado Cartera'
        ];
    }

    public function map($cartera): array
    {
        switch ($cartera->status_est) {
            case 1:
                $estudiante="Activo";
                break;

            case 2:
                $estudiante="InActivo";
                break;

            case 3:
                $estudiante="Desertado";
                break;

            case 4:
                $estudiante="Egresado";
                break;

            case 5:
                $estudiante="Aplazado";
                break;

            case 6:
                $estudiante="Retirado";
                break;

            case 7:
                $estudiante="Reintegro";
                break;

            case 8:
                $estudiante="Acuerdo Pago";
                break;

            case 9:
                $estudiante="Por Iniciar";
                break;

            case 10:
                $estudiante="Retomen Clases";
                break;

            case 11:
                $estudiante="Anulado";
                break;
        }
        return [
            $cartera->responsable->perfil->tipo_documento,
            $cartera->responsable->documento,
            $cartera->responsable->name,
            $cartera->responsable->email,
            $cartera->responsable->perfil->celular,
            $cartera->matricula_id,
            $cartera->matricula->created_at,
            $cartera->matricula->curso->name,
            $cartera->fecha_pago,
            $cartera->fecha_real,
            $cartera->valor,
            $cartera->valor-$cartera->saldo,
            $cartera->saldo,
            $cartera->concepto,
            $cartera->sector->name,
            $cartera->sede->name,
            $cartera->observaciones,
            $estudiante,
            $cartera->estadoCartera->name,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => 'dd/mm/yyyy',
            'G' => 'dd/mm/yyyy',
            'H' => 'dd/mm/yyyy',
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
        $sheet->setTitle('Carteras');
        $sheet->setCellValue('B2', 'LISTADO DE CARTERAS A: '.now());
        $sheet->mergeCells('B2:G2');
    }
}
