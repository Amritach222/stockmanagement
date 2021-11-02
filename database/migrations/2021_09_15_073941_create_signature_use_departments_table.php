<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSignatureUseDepartmentsTable extends Migration {

	public function up()
	{
		Schema::create('signature_use_departments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('department_id')->unsigned();
			$table->integer('signature_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('signature_use_departments');
	}
}