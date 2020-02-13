<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LibroVentaExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ventas = DB::table('ventas as v')
                            ->join('clientes as c', 'c.id', 'v.cliente_id')
                            ->select(DB::raw('3 as especificacion, @curRow as numero, DATE_FORMAT(v.fecha, "%d-%m-%Y") as fecha'), 'v.nro_factura', 'v.nro_autorizacion', 'v.estado', 'c.nit', 'c.razon_social', 'v.importe', 'v.importe_ice', 'v.importe_exento', 'v.tasa_cero', 'v.subtotal', 'v.descuento', 'v.importe_base', 'v.debito_fiscal', 'v.codigo_control')
                            ->where('v.codigo_control', '<>', NULL)
                            ->whereMonth('fecha', session()->get('venta_mes'))
                            ->whereYear('fecha', session()->get('venta_anio'))
                            ->get();
        session()->forget(['venta_mes', 'venta_anio']);
        return $ventas;
    }

    public function headings(): array
    {
        return [
            'Especificación',
            'Numero',
            'Fecha',
            'Nro de factura',
            'Nro de autorización',
            'Estado',
            'CI/NIT',
            'Razón social',
            'Importe',
            'Importe ICE',
            'Importe exento',
            'Tasa cero',
            'Sub total',
            'Descuento',
            'Importe base',
            'Débito fiscal',
            'Código de control'
        ];
    }
}
