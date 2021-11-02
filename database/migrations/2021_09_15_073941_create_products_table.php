<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('code');
            $table->integer('brand_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('image_id')->unsigned()->nullable();
            $table->bigInteger('is_active')->default('1');
            $table->text('details')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('products');
    }
}
