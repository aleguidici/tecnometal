<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesPreestablecidasTable extends Migration
{
    public function up()
    {
        Schema::create('actividades_preestablecidas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->string('descripcion', 255);
            $table->boolean('pendiente')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actividades_preestablecidas');
    }
}
