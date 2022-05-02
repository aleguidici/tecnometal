<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialesTable extends Migration
{
    public function up()
    {
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->bigInteger('unidad_id')->unsigned();
            $table->timestamps();

            $table->foreign('unidad_id')->references('id')->on('unidades')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiales');
    }
}
