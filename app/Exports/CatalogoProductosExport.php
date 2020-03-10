<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CatalogoProductosExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('productos as p')
                    ->join('subcategorias as s', 's.id', 'subcategoria_id')
                    ->select('p.codigo', 'p.nombre', 's.nombre as categoria', 'p.precio_venta as precio', DB::raw("CONCAT(p.estante,' ',p.bloque) as Ubicación"))
                    ->where('p.deleted_at', NULL)
                    ->orderBy('p.nombre')->get();
    }
    
    public function headings(): array
    {
        return [
            'Código',
            'Producto',
            'Categoría',
            'Precio',
            'Ubicación'
        ];
    }
}
