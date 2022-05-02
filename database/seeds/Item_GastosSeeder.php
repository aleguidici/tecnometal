<?php

use App\Item_Gasto;
use App\Item;
use Illuminate\Database\Seeder;

class Item_GastosSeeder extends Seeder
{
    public function run()
    {
        $id_item = Item::where('id',1)->value('id');

        Item_Gasto::create([
            'percentage' => 0.231,
            'descripcion' => 'Impuesto Inmobiliario',
            'item_id' => $id_item
        ]);
        Item_Gasto::create([
            'percentage' => 0.41,
            'descripcion' => 'Beneficio',
            'item_id' => $id_item
        ]);
        Item_Gasto::create([
            'percentage' => 0.021,
            'descripcion' => 'Impuesto a la Ganancia',
            'item_id' => $id_item
        ]);

        $id_item = Item::where('id',2)->value('id');

        Item_Gasto::create([
            'percentage' => 0.41,
            'descripcion' => 'Impuesto Inmobiliario',
            'item_id' => $id_item
        ]);
        Item_Gasto::create([
            'percentage' => 0.1,
            'descripcion' => 'Beneficio',
            'item_id' => $id_item
        ]);
        Item_Gasto::create([
            'percentage' => 0.2,
            'descripcion' => 'Impuesto a la Ganancia',
            'item_id' => $id_item
        ]);
    }
}
