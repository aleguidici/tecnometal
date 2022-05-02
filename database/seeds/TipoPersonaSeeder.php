<?php

use App\TipoPersona;
use Illuminate\Database\Seeder;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TipoPersona::create([
            'name'=>'Cliente'
        ]);

        TipoPersona::create([
            'name'=>'Proveedor'
        ]);
    }
}
