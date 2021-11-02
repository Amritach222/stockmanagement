<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpensesTable extends Migration {

    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('expense_category_id')->unsigned();
            $table->integer('amount')->default('0');
            $table->enum('transaction_type', array('Cash', 'Cheque', 'OnlineTransaction'))->default('Cash');
            $table->integer('bank_account_id')->unsigned()->nullable();
            $table->string('cheque_no', 40)->nullable();
            $table->string('reference_no', 50)->nullable();
            $table->enum('status', array('Pending', 'Approved', 'Rejected'))->default('Pending')->nullable();
            $table->text('note')->nullable();
            $table->integer('file_id')->unsigned()->nullable();
        });
    }

	public function down()
	{
		Schema::drop('expenses');
	}
}
