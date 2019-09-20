<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProformasDetalle extends Model
{
    protected $fillable = ['proforma_id', 'producto_id', 'cantidad'];
}
