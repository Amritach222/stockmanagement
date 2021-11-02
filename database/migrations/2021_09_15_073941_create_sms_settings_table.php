<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsSettingsTable extends Migration {

	public function up()
	{
		Schema::create('sms_settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('gateway', 50)->nullable();
			$table->string('api_key', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('sms_settings');
	}
}
