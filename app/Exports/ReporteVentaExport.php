<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteVentaExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ventas = session()->get('ventasReporteExcel');
        $ventas_aux = [];
        $cont = 0;
        foreach ($ventas as $venta) {
            $detalle_string = '';
            foreach ($venta->detalle as $detalle) {
                $detalle_string .= $detalle->cantidad.' '.$detalle->nombre.', ';
            }
            $ventas[$cont]->detalle = substr($detalle_string, 0, -2).'.';
            $cont++;
        }
        // dd($ventas);
        return session()->get('ventasReporteExcel');
    }
    
    public function headings(): array
    {
        return [
            'Id',
            'Fecha',
            'Cliente',
            'Detalle',
            'Importe',
            'Cobro adicional',
            'Descuento',
            'Total'
        ];
    }
}
