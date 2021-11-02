<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemVariantAttributesTable extends Migration {

	public function up()
	{
		Schema::create('item_variant_attributes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('item_variant_id')->unsigned();
			$table->integer('attribute_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('item_variant_attributes');
	}
}
