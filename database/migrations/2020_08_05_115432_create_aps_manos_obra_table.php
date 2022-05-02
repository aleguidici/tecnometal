<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApsManosObraTable extends Migration
{
    public function up()
    {
        Schema::create('aps_manos_obra', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ap_id')->unsigned();
            $table->bigInteger('mano_obra_id')->unsigned();
            $table->bigInteger('duracion');
            $table->timestamps();

            $table->foreign('ap_id')->references('id')->on('actividades_preestablecidas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('mano_obra_id')->references('id')->on('manos_obra')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aps_manos_obra');
    }
}
