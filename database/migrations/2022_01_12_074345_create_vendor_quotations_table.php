<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_quotations', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->nullable();
            $table->integer('quotation_id')->unsigned()->nullable();
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->integer('vendor_id')->unsigned()->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->integer('total_item')->nullable();
            $table->integer('total_price')->nullable();
            $table->enum('discount_type', ['Percent', 'Amount'])->default('Percent')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('file_id')->unsigned()->nullable();
            $table->foreign('file_id')->references('id')->on('files');
            $table->enum('status', ['Pending', 'On Progress', 'Accepted', 'Approved', 'Rejected', 'Cancelled'])->default('Pending')->nullable();
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
        Schema::dropIfExists('vendor_quotations');
    }
}
