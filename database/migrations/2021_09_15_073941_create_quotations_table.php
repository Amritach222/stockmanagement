<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationsTable extends Migration
{

    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('reference_no', 255)->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('file_id')->unsigned()->nullable();
            $table->enum('status', array('Draft', 'Pending', 'Reviewed', 'Approved', 'Partially Approved', 'Rejected'))->nullable()->default('Pending');
            $table->text('note')->nullable();
            $table->integer('reviewed_by')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::drop('quotations');
    }
}
