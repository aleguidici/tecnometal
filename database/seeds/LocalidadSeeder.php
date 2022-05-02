<?php

use Illuminate\Database\Seeder;
use App\Localidad;
use App\Provincia;


class LocalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id_prov = Provincia::where('name','Misiones')->value('id');

        Localidad::create([
            'name'=>'POSADAS',
            'codigo_postal'=>'3300',
            'provincia_id'=>$id_prov,
        ]);
    }
}
