<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class OfertasDetalle extends Model
{
    protected $fillable = ['oferta_id', 'producto_id', 'tipo_descuento', 'monto'];
}
