<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsManosObraTable extends Migration
{
    public function up()
    {
        Schema::create('items_manos_obra', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->float('precio_unitario', 12, 2);
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('mano_obra_id')->unsigned();
            $table->bigInteger('moneda_id')->unsigned();
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mano_obra_id')->references('id')->on('manos_obra')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('items_manos_obra');
    }
}
