<?php

use App\Material;
use App\Unidad;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        $id_unidad = Unidad::where('descripcion','Unidades')->value('id');

        Material::create([
            'descripcion'=>'Electrodo para soldar acero común',
            'unidad_id' => $id_unidad,
        ]);

        Material::create([
            'descripcion'=>'Electrodo para soldar acero inoxidable',
            'unidad_id' => $id_unidad,
        ]);

        $id_unidad = Unidad::where('descripcion','Litros')->value('id');

        Material::create([
            'descripcion'=>'Pintura epoxi',
            'unidad_id' => $id_unidad,
        ]);

        Material::create([
            'descripcion'=>'Pintura sintética',
            'unidad_id' => $id_unidad,
        ]);

        $id_unidad = Unidad::where('descripcion','Metros cuadrados')->value('id');

        Material::create([
            'descripcion'=>'Goma de 3mm de espesor',
            'unidad_id' => $id_unidad,
        ]);

        Material::create([
            'descripcion'=>'Goma de 4mm de espesor',
            'unidad_id' => $id_unidad,
        ]);

        Material::create([
            'descripcion'=>'Goma de 5mm de espesor',
            'unidad_id' => $id_unidad,
        ]);
    }
}
