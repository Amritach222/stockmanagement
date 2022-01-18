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
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
            $table->enum('discount_type', ['Percent', 'Amount'])->default('Pending')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->enum('status', ['Pending', 'On Progress', 'Accepted', 'Approved', 'Rejected', 'Cancel'])->default('Pending')->nullable();
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
