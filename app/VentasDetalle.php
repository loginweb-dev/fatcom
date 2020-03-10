<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VentasDetalle extends Model
{
    protected $table = 'ventas_detalles';
    protected $fillable = ['venta_id', 'producto_id', 'precio', 'cantidad'];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function productoadicional(){
        return $this->belongsTo(Producto::class,'producto_adicional');
    }
}
