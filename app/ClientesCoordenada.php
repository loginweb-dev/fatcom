<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ClientesCoordenada extends Model
{
    protected $fillable = ['cliente_id', 'nombre', 'lat', 'lon', 'descripcion', 'concurrencia', 'ultima_ubicacion'];
}
