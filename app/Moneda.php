<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $guarded = [];

    protected $table = 'monedas';

    public function items_manos_obra() {
        return $this->hasMany('App\Item_ManoObra');
    }

    public function items_materiales() {
        return $this->hasMany('App\Item_Material');
    }
}
