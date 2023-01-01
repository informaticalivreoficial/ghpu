<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcorrenciaTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocorrencia_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empresa');
            $table->unsignedInteger('autor');
            $table->string('titulo');
            $table->longText('content')->nullable();
            $table->integer('status')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();

            $table->foreign('autor')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('ocorrencia_templates');
    }
}
