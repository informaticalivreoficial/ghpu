<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post')->nullable();
            $table->integer('id_pai')->unsigned()->nullable();
            $table->string('titulo');
            $table->string('tipo');
            $table->text('link')->nullable();
            $table->integer('target')->nullable();
            $table->string('url')->nullable();
            $table->integer('status')->nullable();
            
            $table->timestamps();
            $table->foreign('post')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
