<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBudgetExtendsTable extends Migration
{

    public function up()
    {
        Schema::create('budget_extends', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('department_id')->unsigned();
            $table->integer('amount')->default('0');
            $table->string('remarks', 255)->nullable();
            $table->integer('file_id')->nullable();
            $table->enum('status', array('Pending', 'Approved', 'Rejected'))->default('Pending');
            $table->integer('approved_by')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::drop('budget_extends');
    }
}
