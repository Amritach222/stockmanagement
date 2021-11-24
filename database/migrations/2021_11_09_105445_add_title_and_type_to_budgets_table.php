<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleAndTypeToBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->renameColumn('final_dispatched_amount', 'total_dispatched_amount');
            $table->string('title')->nullable();
            $table->enum('type', ['Annual', 'Extra'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->renameColumn('total_dispatched_amount', 'final_dispatched_amount');
            $table->dropColumn('title');
            $table->dropColumn('type');
        });
    }
}
