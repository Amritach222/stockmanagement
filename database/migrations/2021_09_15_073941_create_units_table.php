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
            $table->integer('category_id')->unsigned()->nullable();
            $table->enum('type', ['smaller', 'equal', 'bigger'])->nullable();
            $table->integer('value')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('units');
    }
}
