<?php

namespace App\Exports;

use App\Models\Financiera\ReciboPago;
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

class FinReciboExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $filtrosede;
    private $filtrocrea;
    private $is_poliandino;
    private $is_logo;
    private $filtrotrans;
    private $filtromedio;
    private $filtrocajero;
    private $filtroconcepto;
    private $fileName = "Recibos.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct(
        $buscamin,
        $filtroSede,
        $filtrocrea,
        $is_poliandino,
        $is_logo,
        $filtrotrans,
        $filtromedio,
        $filtrocajero,
        $filtroconcepto
        )
    {
        $this->buscamin=$buscamin;
        $this->filtrosede=$filtroSede;
        $this->filtrocrea=$filtrocrea;
        $this->is_poliandino=$is_poliandino;
        $this->is_logo=$is_logo;
        $this->filtrotrans=$filtrotrans;
        $this->filtromedio=$filtromedio;
        $this->filtrocajero=$filtrocajero;
        $this->filtroconcepto=$filtroconcepto;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReciboPago::where('origen', $this->is_poliandino)
                            ->buscar($this->buscamin)
                            ->sede($this->filtrosede)
                            ->crea($this->filtrocrea)
                            ->transaccion($this->filtrotrans)
                            ->medio($this->filtromedio)
                            ->cajero($this->filtrocajero)
                            ->tipo($this->filtroconcepto)
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
            'N°',
            'Fecha',
            'Alumno',
            'Documento',
            'Sede',
            'Valor',
            'Descuento',
            'Neto',
            'Detalle',
            'Medio',
            'banco',
            'fecha_transaccion',
            'Cajero',
            'Observaciones'
        ];
    }

    public function map($recibo): array
    {
        $sale=array();
        $detalle = "Concepto | Producto | Cantidad | Valor\n";

        foreach ($recibo->conceptos as $value) {
            $detalle .= "{$value->name} | {$value->pivot->producto} | " .
                    ($value->pivot->cantidad ?? 'N/A') . " | " .
                    number_format($value->pivot->valor, 2) . "\n";
        }

        $neto=$recibo->valor_total-$recibo->descuento;

        array_push($sale,$recibo->numero_recibo);
        array_push($sale,$recibo->fecha);
        array_push($sale,$recibo->paga->name);
        array_push($sale,$recibo->paga->documento);
        array_push($sale,$recibo->sede->name);
        array_push($sale,$recibo->valor_total);
        array_push($sale,$recibo->descuento);
        array_push($sale,$neto);
        array_push($sale,$detalle);
        array_push($sale,$recibo->medio);
        array_push($sale,$recibo->banco);
        array_push($sale,$recibo->fecha_transaccion);
        array_push($sale,$recibo->creador->name);
        array_push($sale,$recibo->observaciones);

        return $sale;
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
        $drawing->setPath(public_path($this->is_logo));
        $drawing->setHeight(70);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Recibos');
        $sheet->setCellValue('C2', 'LISTADO DE RECIBOS A: '.now());
        $sheet->mergeCells('C2:G2');
    }
}
