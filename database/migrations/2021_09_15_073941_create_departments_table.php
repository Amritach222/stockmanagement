<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	public function up()
	{
		Schema::create('departments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 40);
			$table->integer('head_of_department')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('departments');
	}
}