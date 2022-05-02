<?php

use App\Item;
use App\ActividadPreestablecida;
use App\AP_Item;
use Illuminate\Database\Seeder;

class AP_itemSeeder extends Seeder
{
    public function run()
    {
        /* $id_Item = Item::where('id',1)->value('id');
        $id_ActividadPreest = ActividadPreestablecida::where('id',85)->value('id');

        AP_Item::create([
            'ap_id'=>$id_ActividadPreest,
            'item_id'=>$id_Item,
            'cantidad' => 23
        ]);

        $id_Item = Item::where('id',2)->value('id');
        $id_ActividadPreest = ActividadPreestablecida::where('id',85)->value('id');

        AP_Item::create([
            'ap_id'=>$id_ActividadPreest,
            'item_id'=>$id_Item,
            'cantidad' => 13
        ]);

        $id_Item = Item::where('id',1)->value('id');
        $id_ActividadPreest = ActividadPreestablecida::where('id',87)->value('id');

        AP_Item::create([
            'ap_id'=>$id_ActividadPreest,
            'item_id'=>$id_Item,
            'cantidad' => 1
        ]);

        $id_Item = Item::where('id',5)->value('id');
        $id_ActividadPreest = ActividadPreestablecida::where('id',88)->value('id');

        AP_Item::create([
            'ap_id'=>$id_ActividadPreest,
            'item_id'=>$id_Item,
            'cantidad' => 2
        ]); */
    }
}
