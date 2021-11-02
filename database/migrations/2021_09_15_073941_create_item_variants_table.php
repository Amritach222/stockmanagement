<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemVariantsTable extends Migration
{

    public function up()
    {
        Schema::create('item_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('item_id')->unsigned();
            $table->string('code', 255)->nullable();
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('image_id')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::drop('item_variants');
    }
}
