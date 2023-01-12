<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsgUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user');
            $table->longText('content')->nullable();
            $table->string('titulo');
            $table->integer('status')->nullable();

            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msg_users');
    }
}
