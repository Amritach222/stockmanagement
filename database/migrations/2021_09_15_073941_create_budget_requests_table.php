<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBudgetRequestsTable extends Migration
{

    public function up()
    {
        Schema::create('budget_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('fiscal_year_id')->nullable()->unsigned();
            $table->enum('type', ['Annual Request', 'Extend Request'])->nullable();
            $table->integer('request_amount')->default('0');
            $table->integer('file_id')->nullable()->unsigned();
            $table->enum('status', array('Pending', 'Approved', 'Rejected'))->default('Pending');
            $table->integer('approved_by')->unsigned()->nullable();
            $table->string('remarks', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::drop('budget_requests');
    }
}
