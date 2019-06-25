<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UsersCoordenada extends Model
{
    protected $fillable = ['user_id', 'lat', 'lon', 'descripcion', 'concurrencia', 'ultima_ubicacion'];
}
