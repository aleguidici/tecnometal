<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEntidad extends Model
{
    protected $guarded = [];
    
    protected $table = 'tipos_entidad';

    public function entidades() { 
        return $this->hasMany('App\Entidad');
    }
}
