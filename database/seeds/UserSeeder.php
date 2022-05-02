<?php

use Illuminate\Database\Seeder;
use App\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'ADMIN',
            'email'=>'admin@admin',
            'tipo_usuario' => 1,
            'password'=>Hash::make('tecno2020'),
        ]);
    }
}
