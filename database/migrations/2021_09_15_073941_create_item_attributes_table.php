<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemAttributesTable extends Migration {

	public function up()
	{
		Schema::create('item_attributes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->integer('attribute_group_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('item_attributes');
	}
}
