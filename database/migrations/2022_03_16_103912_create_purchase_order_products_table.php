<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_products', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('product_variant_id')->unsigned()->nullable();
            $table->integer('quantity')->nullable()->default('1');
            $table->integer('unit_id')->nullable()->default('1');
            $table->integer('price')->nullable()->default('0');
            $table->integer('tax_id')->unsigned()->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('grand_total')->nullable()->default('0');
            $table->string('supplier');
            $table->unsignedBigInteger('vendor_id');
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
        Schema::dropIfExists('purchase_order_products');
    }
}
