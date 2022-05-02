<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_Gasto extends Model
{
    protected $guarded = [];

    protected $table = 'item_gastos';

    public function item() {
        return $this->belongsTo('App\Item','item_id');
    }
}
