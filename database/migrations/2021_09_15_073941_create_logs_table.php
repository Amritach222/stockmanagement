<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration
{

    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->integer('model_id')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('logs');
    }
}
