<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration {

	public function up()
	{
		Schema::create('files', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('original_name', 255);
			$table->string('name', 255);
			$table->string('type', 100)->nullable();
			$table->string('extension', 100);
			$table->integer('role_id')->nullable();
			$table->string('path', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('files');
	}
}