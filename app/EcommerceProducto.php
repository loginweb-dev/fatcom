<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class EcommerceProducto extends Model
{
    protected $fillable = ['producto_id', 'escasez', 'tags', 'activo'];
}
