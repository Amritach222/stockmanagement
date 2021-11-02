<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBudgetRequestsTable extends Migration {

	public function up()
	{
		Schema::create('budget_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('department_id')->unsigned();
			$table->integer('request_amount')->default('0');
			$table->enum('status', array('Pending', 'Approved', 'Rejected'));
		});
	}

	public function down()
	{
		Schema::drop('budget_requests');
	}
}