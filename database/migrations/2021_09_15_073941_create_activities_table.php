<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	public function up()
	{
		Schema::create('activities', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
		});
	}

	public function down()
	{
		Schema::drop('activities');
	}
}