<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 't_sections';
    protected $fillable = ['t_page_id', 'name', 'description', 'order', 'visible', 'background', 'color'];

    public function blocks(){
        return $this->hasMany('App\Block', 't_section_id');
    }
}
