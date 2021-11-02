<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailSettingsTable extends Migration
{

    public function up()
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('mail_mailer', 70)->nullable();
            $table->string('mail_host', 70)->nullable();
            $table->integer('mail_port')->nullable();
            $table->string('mail_address', 100)->nullable();
            $table->string('username', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('mail_from_name', 100)->nullable();
            $table->string('encryption', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::drop('mail_settings');
    }
}
