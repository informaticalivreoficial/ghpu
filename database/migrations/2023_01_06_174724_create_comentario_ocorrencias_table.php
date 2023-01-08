<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentarioOcorrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario_ocorrencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ocorrencia');
            $table->unsignedInteger('user');
            $table->longText('content')->nullable();
            $table->integer('status')->nullable();

            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('ocorrencia')->references('id')->on('ocorrencias')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario_ocorrencias');
    }
}
