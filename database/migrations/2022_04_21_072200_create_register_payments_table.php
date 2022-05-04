<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable();
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->decimal('total', 8, 2)->default(0)->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->integer('discount')->default(0)->nullable();
            $table->decimal('grand_total', 8, 2)->nullable()->default(0);
            $table->decimal('due_amount', 8, 2)->nullable()->default(0);
            $table->enum('status', ['Pending', 'Accepted', 'Rejected', 'Due', 'Paid'])->nullable()->default('Pending');
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
        Schema::dropIfExists('register_payments');
    }
}
