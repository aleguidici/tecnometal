<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';

    public function provincias() {
        return $this->hasMany('App\Provincia');
    }
}
