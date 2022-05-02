<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    protected $table = 'materiales';

    public function unidad() {
        return $this->belongsTo('App\Unidad');
    }

    public function items_materiales() {
        return $this->hasMany('App\Item_Material');
    }

    public function ap_materiales() {
        return $this->hasMany('App\AP_Material');
    }
}
