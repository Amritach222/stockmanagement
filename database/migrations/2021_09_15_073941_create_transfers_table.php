<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransfersTable extends Migration {

	public function up()
	{
		Schema::create('transfers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('reference_no', 255)->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('from')->unsigned();
			$table->integer('to')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->integer('total_quantity')->default('1');
			$table->integer('total_cost')->default('0');
			$table->integer('total_tax')->nullable()->default('0');
			$table->integer('shipping_cost')->nullable()->default('0');
			$table->integer('grand_total')->nullable()->default('0');
			$table->integer('file_id')->unsigned()->nullable();
			$table->text('note')->nullable();
			$table->enum('status', array('Requested', 'Approved', 'Rejected'))->default('Requested');
		});
	}

	public function down()
	{
		Schema::drop('transfers');
	}
}
