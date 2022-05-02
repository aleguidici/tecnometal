<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_Material extends Model
{
    protected $guarded = [];

    protected $table = 'items_materiales';

    public function item() {
        return $this->belongsTo('App\Item');
    }

    public function material() {
        return $this->belongsTo('App\Material');
    }

    public function moneda() {
        return $this->belongsTo('App\Moneda');
    }

    public function persona() {
        return $this->belongsTo('App\Persona');
    }
}
