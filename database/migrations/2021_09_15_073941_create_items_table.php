<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration
{

    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 255);
            $table->string('code', 255);
            $table->integer('product_id')->unsigned();
            $table->integer('product_variant_id')->unsigned()->nullable();
            $table->integer('stock')->nullable()->default('0');
            $table->integer('alert_stock')->nullable()->default('0');
            $table->integer('brand_id')->unsigned();
            $table->integer('unit_id')->unsigned()->nullable();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->enum('tax_method', array('Included', 'Excluded'))->nullable();
            $table->integer('cost_price')->nullable()->default('0');
            $table->integer('image_id')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::drop('items');
    }
}
