<?php

use App\Presupuesto;
use App\Item;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $id_presupuesto = Presupuesto::where('id',2000001)->value('id');

        Item::create([
            'descripcion' =>'Primer item del Presupuesto 1',
            'cantidad' => 2,
            'presupuesto_id' => $id_presupuesto
        ]);
        Item::create([
            'descripcion' =>'Segundo item del Presupuesto 1',
            'cantidad' => 76,
            'presupuesto_id' => $id_presupuesto
        ]);
        Item::create([
            'descripcion' =>'Tercer item del Presupuesto 1',
            'cantidad' => 34,
            'presupuesto_id' => $id_presupuesto
        ]);

        $id_presupuesto = Presupuesto::where('id',2000002)->value('id');

        Item::create([
            'descripcion' =>'Primer item del Presupuesto 2',
            'cantidad' => 12,
            'presupuesto_id' => $id_presupuesto
        ]);
        Item::create([
            'descripcion' =>'Segundo item del Presupuesto 2',
            'cantidad' => 6,
            'presupuesto_id' => $id_presupuesto
        ]);
        Item::create([
            'descripcion' =>'Tercer item del Presupuesto 2',
            'cantidad' => 11,
            'presupuesto_id' => $id_presupuesto
        ]);
    }
}
