<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFreezeBudgetsTable extends Migration
{

    public function up()
    {
        Schema::create('freeze_budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('department_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned()->nullable();
            $table->integer('amount')->default('0');
            $table->string('remark', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::drop('freeze_budgets');
    }
}
