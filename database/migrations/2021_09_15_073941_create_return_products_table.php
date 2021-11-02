<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnProductsTable extends Migration {

	public function up()
	{
		Schema::create('return_products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('reference_no', 255)->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('purchase_id')->unsigned();
			$table->integer('purchase_product_id')->unsigned()->nullable();
			$table->integer('quantity')->nullable()->default('1');
			$table->integer('shipping_cost')->nullable()->default('0');
			$table->integer('total_cost')->default('0');
			$table->text('note')->nullable();
			$table->integer('file_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('return_products');
	}
}
