<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationProductsTable extends Migration {

	public function up()
	{
		Schema::create('quotation_products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('quotation_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->integer('item_variant_id')->unsigned()->nullable();
			$table->integer('quantity')->nullable()->default('1');
			$table->integer('price')->nullable()->default('0');
			$table->integer('tax_id')->unsigned()->nullable();
			$table->integer('shipping_cost')->nullable();
			$table->integer('grand_total')->nullable()->default('0');
		});
	}

	public function down()
	{
		Schema::drop('quotation_products');
	}
}
