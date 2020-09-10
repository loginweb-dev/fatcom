<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proforma extends Model
{
    use SoftDeletes;
    protected $fillable = ['codigo', 'cliente_id','user_id'];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function cliente () {
        return $this->belongsTo(Cliente::class);
    }

    public function detalle () {
        return $this->hasMany(ProformasDetalle::class);
    }
}
