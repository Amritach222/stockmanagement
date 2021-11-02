<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{

    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title', 60);
            $table->integer('logo_id')->unsigned()->nullable();
            $table->string('currency', 70)->nullable();
            $table->string('time_zone', 100)->nullable();
            $table->string('date_format', 60)->nullable()->default('yyyy-mm-dd');
            $table->unsignedInteger('fiscal_year_id')->nullable();
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years')->onDelete(null);
        });
    }

    public function down()
    {
        Schema::drop('settings');
    }
}
