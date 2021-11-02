<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDesignationsTable extends Migration {

	public function up()
	{
		Schema::create('designations', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->integer('level');
		});
	}

	public function down()
	{
		Schema::drop('designations');
	}
}