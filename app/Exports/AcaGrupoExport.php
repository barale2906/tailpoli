<?php

namespace App\Exports;

use App\Models\Academico\Grupo;
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

class AcaGrupoExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $fileName = "Grupos.xlsx";
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
        return Grupo::query()
                        ->with(['modulo', 'profesor'])
                        ->when($this->buscamin, function($query){
                            return $query->where('status', true)
                                    ->where('name', 'like', "%".$this->buscamin."%")
                                    ->orWhereHas('modulo', function($q){
                                        $q->where('name', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('profesor', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    });
                        })
                        ->orderBy('name', 'ASC')
                        ->get();
    }public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Modulo',
            'Curso',
            'Inicia',
            'Finaliza',
            'Máximo Estudiantes',
            'Inscritos',
            'Profesor',
            'Fecha de Creación'
        ];
    }

    public function map($grupo): array
    {
        return [
            $grupo->name,
            $grupo->modulo->name,
            $grupo->modulo->curso->name,
            $grupo->start_date,
            $grupo->finish_date,
            $grupo->quantity_limit,
            $grupo->inscritos,
            $grupo->profesor->name,
            Date::dateTimeToExcel($grupo->created_at)
        ];
    }

    public function columnFormats(): array
    {
        return [
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
        $sheet->setTitle('Grupos');
        $sheet->setCellValue('B2', 'LISTADO DE GRUPOS A: '.now());
        $sheet->mergeCells('B2:H2');
    }
}
