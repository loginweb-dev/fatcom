<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{
    protected $fillable = ['nombre', 'movil', 'direccion', 'user_id'];
}
