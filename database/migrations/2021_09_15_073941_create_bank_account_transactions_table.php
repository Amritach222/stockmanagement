<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankAccountTransactionsTable extends Migration {

	public function up()
	{
		Schema::create('bank_account_transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('account_id')->unsigned();
			$table->double('transaction_amount')->nullable();
			$table->string('transaction_type', 64)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('bank_account_transactions');
	}
}
