<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AP_Item extends Model
{
    protected $guarded = [];

    protected $table = 'aps_items';

    public function item() {
        return $this->belongsTo('App\Item');
    }

    public function actividad_preestablecida() {
        return $this->belongsTo('App\ActividadPreestablecida','ap_id');
    }
}
