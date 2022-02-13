<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseProductIdToQuotationProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->integer('purchase_product_id')->unsigned()->nullable();
            $table->foreign('purchase_product_id')->references('id')->on('purchase_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->dropColumn('purchase_product_id');
        });
    }
}
