<?php

use App\Pais;

use Illuminate\Database\Seeder;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('paises')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); */
        $paises = [
            ['id' => '1', 'name' => 'ARGENTINA', 'iso_alfa3' => 'ARG', 'iso_num' => '032'],
            ['id' => '2', 'name' => 'PARAGUAY', 'iso_alfa3' => 'PRY', 'iso_num' => '600'],
            ['id' => '3', 'name' => 'BRASIL', 'iso_alfa3' => 'BRA', 'iso_num' => '076'],
            ['id' => '4', 'name' => 'ESTADOS UNIDOS', 'iso_alfa3' => 'USA', 'iso_num' => '840']
        ];

        foreach ($paises as $un_pais){
            Pais::create($un_pais);
        }
    }
}
