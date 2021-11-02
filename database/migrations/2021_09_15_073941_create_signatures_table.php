<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSignaturesTable extends Migration {

	public function up()
	{
		Schema::create('signatures', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('file_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('designation_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('signatures');
	}
}
