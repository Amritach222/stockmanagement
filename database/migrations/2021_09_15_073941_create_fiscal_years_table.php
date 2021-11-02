<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFiscalYearsTable extends Migration {

	public function up()
	{
		Schema::create('fiscal_years', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->date('from');
			$table->date('to');
		});
	}

	public function down()
	{
		Schema::drop('fiscal_years');
	}
}