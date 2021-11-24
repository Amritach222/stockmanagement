<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetRequestCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_request_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('budget_request_id')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('amount')->nullable();
            $table->string('note')->nullable();

            $table->foreign('budget_request_id')->references('id')->on('budget_requests');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_request_categories');
    }
}
