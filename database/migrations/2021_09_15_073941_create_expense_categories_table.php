<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpenseCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('expense_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 45);
			$table->string('code', 50)->nullable();
			$table->boolean('is_active')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('expense_categories');
	}
}