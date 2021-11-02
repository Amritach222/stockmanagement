<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemAttributeGroupsTable extends Migration {

	public function up()
	{
		Schema::create('item_attribute_groups', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
		});
	}

	public function down()
	{
		Schema::drop('item_attribute_groups');
	}
}