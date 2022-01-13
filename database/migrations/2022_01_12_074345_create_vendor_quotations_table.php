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
            $table->integer('quotation_id')->unsigned()->nullable();
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->integer('quotation_product_id')->unsigned()->nullable();
            $table->foreign('quotation_product_id')->references('id')->on('quotation_products');
            $table->integer('vendor_id')->unsigned()->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->enum('status', ['Pending', 'Reviewed', 'Approved', 'Rejected', 'Cancel'])->default('Pending')->nullable();
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
