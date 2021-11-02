<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxesTable extends Migration {

	public function up()
	{
		Schema::create('taxes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 90);
			$table->integer('value');
		});
	}

	public function down()
	{
		Schema::drop('taxes');
	}
}