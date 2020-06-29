<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VentasSeguimiento extends Model
{
    protected $fillable = ['venta_id', 'venta_estado_id'];

    public function ventaestado(){
        return $this->belongsTo('App\VentasEstado', 'venta_estado_id');
    }
}
