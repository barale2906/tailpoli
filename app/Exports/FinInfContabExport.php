<?php

namespace App\Exports;

use App\Models\Financiera\CierreCaja;
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

class FinInfContabExport implements FromCollection, WithCustomStartCell, Responsable, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDrawings, WithStyles
{
    use Exportable;

    private $buscamin;
    private $filtroSede;
    private $filtrocrea;
    private $ids=array();
    private $fileName = "Recibos_contabilidad_credito.xlsx";
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;

    public function __construct($buscamin,$filtroSede,$filtrocrea)
    {
        $this->buscamin=$buscamin;
        $this->filtroSede=$filtroSede;
        $this->filtrocrea=$filtrocrea;

        $cierres=CierreCaja::buscar($this->buscamin)
                            ->sede($this->filtroSede)
                            ->crea($this->filtrocrea)
                            ->select('id')
                            ->get();

        foreach ($cierres as $value) {
            array_push($this->ids,$value->id);
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReciboPago::where('origen', true)
                            ->whereIn('cierre', $this->ids)
                            ->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Encab: Empresa',
            'Encab: Tipo Documento',
            'Encab: Prefijo',
            'Encab: Fecha',
            'Encab: Tercero Interno',
            'Encab: Tercero Externo',
            'Encab: Verificado',
            'Encab: Recaudado por',
            'Encab: Fecha Recaudo',
            'Detalle Con: IdCuentaContable',
            'Detalle Con: Nota',
            'Detalle Con: Tercero_Externo',
            'Detalle Con: Débito',
            'Detalle Con: Crédito',
            'Detalle Con: Vencimiento',
            'Detalle Con: Centro costos'
        ];
    }

    public function map($recibo): array
    {
        switch ($recibo->sede_id) {
            case 1:
                $sede='SAN JOSE A';
                break;

            case 3:
                $sede='CHC';
                break;

            case 4:
                $sede='CHD';
                break;

            case 7:
                $sede='CALI';
                break;

            case 8:
                $sede='VILLAVICENCIO';
                break;

            case 9:
                $sede='MEDELLIN';
                break;

            case 10:
                $sede='IBAGUE';
                break;

            case 11:
                $sede='FACATATIVA';
                break;

            default:
                $sede=$recibo->sede->name;
                break;
        }
        $lineas=array();


        $credito = [
                    'INSTITUTO DE CAPACITACION POLIANDINO CENTRAL SAS',
                    'RC',
                    'INGR',
                    $recibo->fecha,
                    '900656857',
                    $recibo->paga->documento,
                    '-1',
                    '900656857',
                    $recibo->fecha,
                    270545,
                    'RECAUDO RECIBO '.$recibo->numero_recibo,
                    $recibo->paga->documento,
                    0,
                    $recibo->valor_total,
                    $recibo->fecha,
                    $sede
                ];

        $debito = [
                    'INSTITUTO DE CAPACITACION POLIANDINO CENTRAL SAS',
                    'RC',
                    'INGR',
                    $recibo->fecha,
                    '900656857',
                    $recibo->paga->documento,
                    '-1',
                    '900656857',
                    $recibo->fecha,
                    11050501,
                    'RECAUDO RECIBO '.$recibo->numero_recibo,
                    $recibo->paga->documento,
                    $recibo->valor_total,
                    0,
                    $recibo->fecha,
                    $sede
                ];

        array_push($lineas, $credito);
        array_push($lineas, $debito);

        return $lineas;
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
        $sheet->setTitle('Recibos contabilidad');
        $sheet->setCellValue('C2', 'LISTADO DE RECIBOS A: '.now());
        $sheet->mergeCells('C2:P2');
    }
}
