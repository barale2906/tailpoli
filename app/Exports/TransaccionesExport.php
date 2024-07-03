<?php

namespace App\Exports;

use App\Models\Financiera\Transaccion;
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


class TransaccionesExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $id_estado;
    private $filtrocrea;
    private $fileName = "Transacciones.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin,$filtrocrea,$id_estado)
    {
        $this->buscamin=$buscamin;
        $this->id_estado=$id_estado;
        $this->filtrocrea=$filtrocrea;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaccion::buscar($this->buscamin)
                            ->estado($this->id_estado)
                            ->crea($this->filtrocrea)
                            ->orderBy('id', 'ASC')
                            ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Sede',
            'Creador',
            'Estudiante',
            'Valor por inventario',
            'Valor por acádemico',
            'Valor total',
            'Banco',
            'Fecha de transacción',
            'Observaciones'
        ];
    }

    public function map($item): array
    {
        return [
                $item->fecha,
                $item->sede->name,
                $item->creador->name,
                $item->user->name,
                $item->inventario,
                $item->academico,
                $item->total,
                $item->banco,
                $item->fecha_transaccion,
                $item->observaciones
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
        $sheet->setTitle('Transacciones');
        $sheet->setCellValue('C2', 'LISTADO  DE TRANSACCIONES SEGÚN PARÁMETRO DE BÚSQUEDA A '.now());
        $sheet->mergeCells('C2:P2');
    }
}
