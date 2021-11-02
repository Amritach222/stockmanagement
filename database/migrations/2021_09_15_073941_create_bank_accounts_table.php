<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankAccountsTable extends Migration {

	public function up()
	{
		Schema::create('bank_accounts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('bank_name', 255);
			$table->string('account_no', 64);
			$table->string('account_name', 255);
			$table->bigInteger('total_balance')->nullable()->default(0);
			$table->double('current_balance')->default(0);
			$table->string('branch', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('bank_accounts');
	}
}
