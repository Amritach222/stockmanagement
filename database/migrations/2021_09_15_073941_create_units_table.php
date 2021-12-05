<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitsTable extends Migration
{

    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 55);
            $table->string('short_code', 55);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('units');
            $table->integer('value')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('units');
    }
}
