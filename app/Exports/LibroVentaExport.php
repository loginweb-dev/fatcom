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
        $importe = 0; $importe_ice = 0; $importe_exento = 0; $tasa_cero = 0; $subtotal = 0; $descuento = 0; $importe_base = 0; $debito_fiscal = 0; $cont = 1;
        foreach ($ventas as $venta) {
            $importe += $venta->importe;
            $importe_ice += $venta->importe_ice;
            $importe_exento += $venta->importe_exento;
            $tasa_cero += $venta->tasa_cero;
            $subtotal += $venta->subtotal;
            $descuento += $venta->descuento;
            $importe_base += $venta->importe_base;
            $debito_fiscal += $venta->debito_fiscal;
            $ventas[$cont-1]->numero = $cont;
            $cont++;
        }
        $total = collect(['','','','','','','','',number_format($importe,2,'.',','), number_format($importe_ice,2,'.',','), number_format($importe_exento,2,'.',','), number_format($tasa_cero,2,'.',','), number_format($subtotal,2,'.',','), number_format($descuento,2,'.',','), number_format($importe_base,2,'.',','), number_format($debito_fiscal,2,'.',','), '']);
        $ventas->push($total);
        // dd($ventas);
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
