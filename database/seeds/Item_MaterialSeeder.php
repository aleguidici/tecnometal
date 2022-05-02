<?php

use App\Item;
use App\Material;
use App\Moneda;
use App\Item_Material;
use Illuminate\Database\Seeder;

class Item_MaterialSeeder extends Seeder
{
    public function run()
    {
        $id_item = Item::where('id',4)->value('id');
        $id_material = Material::where('id',1)->value('id');
        $id_moneda = Moneda::where('id',1)->value('id');

        Item_Material::create([
            'cantidad' => 2,
            'precio_unitario' => 1468.5,
            'codigo'=>"002252",
            'marca'=>"Electrodos Soldar Acindar (6013)",
            'item_id'=>$id_item,
            'material_id'=>$id_material,
            'moneda_id'=>$id_moneda,
            'persona_id'=>1,
            'reventa' => true,
        ]);

        $id_item = Item::where('id',1)->value('id');
        $id_material = Material::where('id',1)->value('id');
        $id_moneda = Moneda::where('id',2)->value('id');

        Item_Material::create([
            'cantidad' => 7,
            'precio_unitario' => 168.5,
            'codigo'=>"002253",
            'marca'=>"Electrodos Soldar Acindar (7018)",
            'item_id'=>$id_item,
            'material_id'=>$id_material,
            'moneda_id'=>$id_moneda,
            'persona_id'=>1,
            'reventa' => true,
        ]);

        $id_item = Item::where('id',3)->value('id');
        $id_material = Material::where('id',2)->value('id');
        $id_moneda = Moneda::where('id',3)->value('id');

        Item_Material::create([
            'cantidad' => 1,
            'precio_unitario' => 33168.5,
            'codigo'=>"002254",
            'marca'=>"Electrodos 316 2,50mm",
            'item_id'=>$id_item,
            'material_id'=>$id_material,
            'moneda_id'=>$id_moneda,
            'persona_id'=>1,
            'reventa' => true,
        ]);

        $id_item = Item::where('id',4)->value('id');
        $id_material = Material::where('id',2)->value('id');
        $id_moneda = Moneda::where('id',4)->value('id');

        Item_Material::create([
            'cantidad' => 2,
            'precio_unitario' => 331368.5,
            'codigo'=>"002255",
            'marca'=>"Electrodos Soldar Acindar (6011)",
            'item_id'=>$id_item,
            'material_id'=>$id_material,
            'moneda_id'=>$id_moneda,
            'persona_id'=>1,
            'reventa' => false,
        ]);
    }
}
