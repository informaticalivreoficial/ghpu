<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcorrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocorrencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('colaborador');
            $table->unsignedInteger('empresa');
            $table->string('titulo');
            $table->longText('content')->nullable();
            $table->integer('status')->nullable();
            $table->bigInteger('views')->default(0);
            $table->integer('update_user')->nullable();
            $table->string('template')->nullable();

            $table->timestamps();

            $table->foreign('colaborador')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('empresa')->references('id')->on('empresas')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ocorrencias');
    }
}
