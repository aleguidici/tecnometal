<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $guarded = [];

    protected $fileable = ['name','provincia_id','codigo_postal'];

    protected $table = 'localidades';

    public function provincia(){
        return $this->belongsTo('App\Provincia');
    }

    public function personas() {
        return $this->hasMany('App\Persona');
    }
}
