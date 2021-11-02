<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBudgetsTable extends Migration
{

    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('department_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->integer('allocated_budget_amount')->default('0');
            $table->integer('initial_dispatched_amount')->default('0');
            $table->integer('final_dispatched_amount')->default('0');
            $table->date('date_first_received')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->integer('file_id')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('budgets');
    }
}
