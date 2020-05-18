<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 't_pages';
    protected $fillable = ['t_template_id', 'name', 'description'];

    public function sections(){
        return $this->hasMany('App\Section', 't_page_id');
    }
}
