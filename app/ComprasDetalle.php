<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ComprasDetalle extends Model
{
    protected $fillable = ['compra_id', 'producto_id', 'precio', 'cantidad'];
}
