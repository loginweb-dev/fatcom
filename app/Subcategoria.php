<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Subcategoria extends Model
{
    use SoftDeletes;
    use Sluggable;
    protected $dates = ['deleted_at'];
    protected $fillable = ['nombre', 'descripcion', 'categoria_id'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nombre'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
