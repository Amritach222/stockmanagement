<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseProductsTable extends Migration {

	public function up()
	{
		Schema::create('purchase_products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('purchase_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('item_id')->unsigned()->nullable();
			$table->integer('item_variant_id')->unsigned()->nullable();
			$table->integer('vendor_id')->unsigned()->nullable();
			$table->integer('quantity')->nullable()->default('1');
			$table->integer('price')->nullable()->default('0');
			$table->integer('tax_id')->unsigned()->nullable();
			$table->integer('total_price')->nullable()->default('0');
		});
	}

	public function down()
	{
		Schema::drop('purchase_products');
	}
}
