<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $guarded = [];

    protected $table = 'contactos';

    public function persona() {
        return $this->belongsTo('App\Persona');
    }
}
