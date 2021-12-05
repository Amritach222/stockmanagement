<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAttributesTable extends Migration {

	public function up()
	{
		Schema::create('product_attributes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->integer('attribute_group_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('product_attributes');
	}
}
