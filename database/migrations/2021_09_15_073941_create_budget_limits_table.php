<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBudgetLimitsTable extends Migration
{

    public function up()
    {
        Schema::create('budget_limits', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('category_id')->unsigned();
            $table->integer('amount')->default(0);
        });
    }

    public function down()
    {
        Schema::drop('budget_limits');
    }
}
