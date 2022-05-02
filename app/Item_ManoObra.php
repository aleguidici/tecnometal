<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_ManoObra extends Model
{
    protected $guarded = [];

    protected $table = 'items_manos_obra';

    public function item() {
        return $this->belongsTo('App\Item');
    }

    public function mano_obra() {
        return $this->belongsTo('App\ManoObra');
    }
    
    public function moneda() {
        return $this->belongsTo('App\Moneda');
    }
}
