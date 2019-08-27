<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Producto extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nombre'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    protected $fillable = ['nombre', 'descripcion_small', 'descripcion_long', 'precio_venta', 'precio_minimo', 'ultimo_precio_compra', 'codigo', 'codigo_grupo', 'codigo_barras', 'estante', 'bloque', 'stock', 'stock_minimo', 'codigo_interno', 'subcategoria_id', 'marca_id', 'talla_id', 'color_id', 'genero_id', 'unidad_id', 'uso_id', 'modelo', 'moneda_id', 'garantia', 'catalogo', 'nuevo', 'se_almacena', 'imagen', 'vistas', 'slug'];
}
