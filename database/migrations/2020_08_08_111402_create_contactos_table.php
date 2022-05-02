<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactosTable extends Migration
{
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('persona_id')->unsigned();
            $table->timestamps();

            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contactos');
    }
}
