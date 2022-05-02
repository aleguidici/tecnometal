<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApsMaterialesTable extends Migration
{
    public function up()
    {
        Schema::create('aps_materiales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ap_id')->unsigned();
            $table->bigInteger('material_id')->unsigned();
            $table->float('cantidad');
            $table->timestamps();

            $table->foreign('ap_id')->references('id')->on('actividades_preestablecidas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('material_id')->references('id')->on('materiales')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aps_materiales');
    }
}
