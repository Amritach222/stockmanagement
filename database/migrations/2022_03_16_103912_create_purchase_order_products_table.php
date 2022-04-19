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
            $table->integer('purchase_order_id')->unsigned()->nullable();
            $table->integer('quotation_product_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('product_variant_id')->unsigned()->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->integer('received_quantity')->nullable()->default(0);
            $table->integer('price')->nullable()->default(0);
            $table->decimal('total', 8, 2)->nullable()->default(0);
            $table->string('discount_type')->nullable();
            $table->decimal('discount', 8, 2)->nullable()->default(0);
            $table->integer('unit_id')->unsigned()->nullable();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->decimal('grand_total', 8, 2)->nullable()->default(0);
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
