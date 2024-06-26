<?php

namespace App\Exports;

use App\Models\Academico\Ciclo;
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

class AcaCicloExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $sede;
    private $curso;
    private $inicia;
    private $buscamin;
    private $jornada;
    private $fileName = "Ciclos.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin,$sede,$curso,$inicia,$jornada)
    {
        $this->buscamin=$buscamin;
        $this->sede=$sede;
        $this->curso=$curso;
        $this->inicia=$inicia;
        $this->jornada=$jornada;

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ciclo::where('status', true)
                    ->buscar($this->buscamin)
                    ->sede($this->sede)
                    ->curso($this->curso)
                    ->inicia($this->inicia)
                    ->jornada($this->filtrojornada)
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
            'Inicia',
            'Finaliza',
            'Registrados',
            'Jornada',
            'Estado',
            'grupos',
        ];
    }

    public function map($ciclo): array
    {
        $grupos=array();

        foreach ($ciclo->ciclogrupos as $value) {
            array_push($grupos,$value->grupo->name);
        }
        return [
            $ciclo->name,
            $ciclo->inicia,
            $ciclo->finaliza,
            $ciclo->registrados,
            $ciclo->jornada,
            $ciclo->status,
            $grupos
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => 'dd/mm/yyyy',
            'C' => 'dd/mm/yyyy',
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
        $sheet->setTitle('Ciclos');
        $sheet->setCellValue('C2', 'LISTADO DE CICLOS A: '.now());
        $sheet->mergeCells('C2:E2');
        $sheet->setCellValue('C3', 'Jornada 1 Mañana, 2 Tarde, 3 Noche, 4 Fin de semana');
        $sheet->mergeCells('C3:E3');
        $sheet->setCellValue('C4', 'Estado 1 Aprobado, 2 Activo, 3 Inactivo');
        $sheet->mergeCells('C4:E4');
    }
}
