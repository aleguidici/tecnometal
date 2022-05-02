<?php

use App\Item;
use App\ManoObra;
use App\Moneda;
use App\Item_ManoObra;
use Illuminate\Database\Seeder;

class Item_ManoObraSeeder extends Seeder
{
    public function run()
    {
        $id_item = Item::where('id',2)->value('id');
        $id_manoObra = ManoObra::where('id',1)->value('id');
        $id_moneda = Moneda::where('id',1)->value('id');

        Item_ManoObra::create([
            'cantidad' => 2,
            'precio_unitario' => 1468.5,
            'item_id'=>$id_item,
            'mano_obra_id'=>$id_manoObra,
            'moneda_id'=>$id_moneda
        ]);

        $id_item = Item::where('id',1)->value('id');
        $id_manoObra = ManoObra::where('id',1)->value('id');
        $id_moneda = Moneda::where('id',2)->value('id');

        Item_ManoObra::create([
            'cantidad' => 7,
            'precio_unitario' => 168.5,
            'item_id'=>$id_item,
            'mano_obra_id'=>$id_manoObra,
            'moneda_id'=>$id_moneda
        ]);

        $id_item = Item::where('id',3)->value('id');
        $id_manoObra = ManoObra::where('id',1)->value('id');
        $id_moneda = Moneda::where('id',3)->value('id');

        Item_ManoObra::create([
            'cantidad' => 1,
            'precio_unitario' => 33168.5,
            'item_id'=>$id_item,
            'mano_obra_id'=>$id_manoObra,
            'moneda_id'=>$id_moneda
        ]);

        $id_item = Item::where('id',4)->value('id');
        $id_manoObra = ManoObra::where('id',1)->value('id');
        $id_moneda = Moneda::where('id',4)->value('id');

        Item_ManoObra::create([
            'cantidad' => 2,
            'precio_unitario' => 331368.5,
            'item_id'=>$id_item,
            'mano_obra_id'=>$id_manoObra,
            'moneda_id'=>$id_moneda
        ]);
    }
}
