<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class HojasTrabajosDetalle extends Model
{
    protected $fillable = ['hoja_trabajo_id', 'producto_id', 'cantidad'];
}
