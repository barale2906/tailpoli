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

    private $buscamin;
    private $fileName = "Ciclos.xlsx";
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
        return Ciclo::query()
                    ->with(['sede', 'curso'])
                    ->when($this->buscamin, function($query){
                        return $query->where('status', true)
                                ->where('name', 'like', "%".$this->buscamin."%")
                                ->orWhereHas('sede', function($q){
                                    $q->where('name', 'like', "%".$this->buscamin."%");
                                })
                                ->orWhereHas('curso', function($qu){
                                    $qu->where('name', 'like', "%".$this->buscamin."%");
                                });
                    })
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
            'Estado'
        ];
    }

    public function map($ciclo): array
    {
        return [
            $ciclo->name,
            $ciclo->inicia,
            $ciclo->finaliza,
            $ciclo->registrados,
            $ciclo->jornada,
            $ciclo->status
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
        $sheet->setCellValue('C4', 'Estado 1 elaboración, 2 Aprobado, 3 Activo, 4 Inactivo');
        $sheet->mergeCells('C4:E4');
    }
}
