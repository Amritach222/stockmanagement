<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductVariantAttributesTable extends Migration {

	public function up()
	{
		Schema::create('product_variant_attributes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_variant_id')->unsigned();
			$table->integer('attribute_id')->unsigned();
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('product_variant_attributes');
	}
}
