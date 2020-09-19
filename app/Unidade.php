<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidade extends Model
{
    use SoftDeletes;
    protected $table = "unidades";
    protected $dates = ['deleted_at'];
    protected $fillable = ['nombre', 'abreviacion'];
}
