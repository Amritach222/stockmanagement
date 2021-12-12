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
            $table->decimal('stock',8,8)->nullable()->default('0');
            $table->integer('alert_stock')->nullable()->default('0');
            $table->integer('unit_id')->unsigned()->nullable();
            $table->integer('distribute_unit_id')->unsigned()->nullable();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->enum('tax_method', array('Included', 'Excluded'))->nullable();
            $table->integer('cost_price')->nullable()->default('0');
            $table->text('details')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('products');
    }
}
