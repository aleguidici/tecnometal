<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApsItems extends Migration
{
    public function up()
    {
        Schema::create('aps_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ap_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('ap_id')->references('id')->on('actividades_preestablecidas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aps_items');
    }
}
