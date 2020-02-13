<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LibroCompraExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $compras = DB::table('compras')
                            ->select(DB::raw('DATE_FORMAT(fecha, "%d-%m-%Y") as someDate'), 'nit', 'razon_social', 'nro_factura', 'nro_dui', 'nro_autorizacion', 'importe_compra', 'monto_exento', 'sub_total', 'descuento', 'importe_base', 'credito_fiscal', 'codigo_control', 'tipo_compra')
                            ->where('nro_factura', '<>', NULL)
                            ->whereMonth('fecha', session()->get('compra_mes'))
                            ->whereYear('fecha', session()->get('compra_anio'))
                            ->get();
        session()->forget(['compra_mes', 'compra_anio']);
        return $compras;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'NIT',
            'Razon social',
            'Nro de factura',
            'Nro de DUI',
            'Nro de autorización',
            'Importe',
            'Importe exento',
            'Sub total',
            'Descuento',
            'Importe base',
            'Crédito fiscal',
            'Código de control',
            'Tipo compra'
        ];
    }
}
