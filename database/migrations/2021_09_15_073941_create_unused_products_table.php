<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnusedProductsTable extends Migration {

	public function up()
	{
		Schema::create('unused_products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('code', 255);
			$table->integer('item_id')->unsigned();
			$table->integer('item_variant_id')->unsigned()->nullable();
			$table->integer('department_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('approved_by')->unsigned()->nullable();
			$table->integer('image_id')->unsigned()->nullable();
			$table->text('note')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('unused_products');
	}
}