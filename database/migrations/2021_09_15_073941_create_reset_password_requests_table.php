<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResetPasswordRequestsTable extends Migration {

	public function up()
	{
		Schema::create('reset_password_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('reset_by')->unsigned()->nullable();
			$table->datetime('reset_on')->nullable();
			$table->enum('status', array('Pending', 'Reset', 'Cancelled'));
		});
	}

	public function down()
	{
		Schema::drop('reset_password_requests');
	}
}