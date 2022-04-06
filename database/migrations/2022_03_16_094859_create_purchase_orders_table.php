<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->date('date_of_order')->nullable();
            $table->date('shipping_date')->nullable();
            $table->string('requester');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('supplier')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('dept_id')->nullable();
            $table->enum('status', array('Draft', 'Pending', 'Approved', 'Not Sent', 'Sent', 'Message Received',
                'In Revision', 'Matching', 'Rejected', 'Stopped', 'Cancelled', 'Received', 'Paid/Not Paid',
                'Completed'))->default('Pending');
            $table->longText('description')->nullable();
            $table->integer('file_id')->unsigned()->nullable();
            $table->float('total')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
