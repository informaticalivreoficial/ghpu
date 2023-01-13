<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOcorrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ocorrencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user');   
            $table->integer('remetente')->nullable();         
            $table->unsignedInteger('ocorrencia');            
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
        Schema::dropIfExists('user_ocorrencias');
    }
}
