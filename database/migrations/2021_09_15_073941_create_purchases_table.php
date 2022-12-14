<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchasesTable extends Migration
{

    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('reference_no', 255)->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('total_item')->nullable()->default('0');
            $table->integer('total_quantity')->nullable()->default('0');
            $table->integer('total_tax')->nullable();
            $table->integer('total_cost')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('grand_total')->nullable();
            $table->integer('paid_amount')->nullable()->default('0');
            $table->enum('status', array('Pending', 'Approved', 'Partial Approved', 'Rejected', 'Partial Rejected'))->default('Pending');
            $table->enum('payment_status', array('Unpaid', 'Partial', 'Paid'))->default('Unpaid');
            $table->text('note')->nullable();
            $table->integer('file_id')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->enum('seen_status', array('seen', 'unseen'))->default('unseen');
        });
    }

    public function down()
    {
        Schema::drop('purchases');
    }
}
