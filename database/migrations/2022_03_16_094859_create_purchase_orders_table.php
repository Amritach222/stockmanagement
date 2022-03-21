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
            $table->date('date_of_order');
            $table->date('shipping_date');
            $table->string('requester');
            $table->string('supplier');
            $table->unsignedBigInteger('vendor_id');
            $table->string('location');
            $table->unsignedBigInteger('dept_id');
            $table->enum('status', array('Draft', 'Pending', 'Approved', 'Not Sent', 'Sent', 'Message Received',
                'In Revision', 'Matching', 'Rejected', 'Stopped', 'Cancelled', 'Partly Received', 'Paid/Not Paid',
                'Completed'))->default('Draft');
            $table->longText('description');
            $table->integer('file_id')->unsigned()->nullable();
            $table->float('total');
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
