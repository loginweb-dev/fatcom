<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $dates = ['deleted_at'];
    protected $fillable = ['nombre', 'slug', 'logo'];

    public function sluggable(){
        return [
            'slug' => [
                'source' => 'nombre'
            ]
        ];
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
