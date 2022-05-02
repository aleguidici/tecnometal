<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $guarded = [];

    protected $table = 'unidades';

    public function materiales() { 
        return $this->hasMany('App\Material');
    }
}
