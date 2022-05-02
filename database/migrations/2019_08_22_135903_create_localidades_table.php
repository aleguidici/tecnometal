<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('provincia_id')->unsigned();
            $table->foreign('provincia_id')->references('id')->on('provincias')->onDelete('restrict')->onUpdate('cascade');
            $table->string('codigo_postal');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}
