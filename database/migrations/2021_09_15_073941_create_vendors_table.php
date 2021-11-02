<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendorsTable extends Migration {

	public function up()
	{
		Schema::create('vendors', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->string('company_name', 255);
			$table->integer('image_id')->unsigned()->nullable();
			$table->bigInteger('vat_no')->nullable();
			$table->string('email', 70);
			$table->string('address', 255)->nullable();
			$table->bigInteger('landline')->nullable();
			$table->bigInteger('mobile')->nullable();
			$table->string('country')->nullable();
			$table->string('state')->nullable();
			$table->string('city')->nullable();
			$table->string('postal_code')->nullable();
			$table->integer('category_id')->unsigned()->nullable();
			$table->bigInteger('is_active')->default('1');
		});
	}

	public function down()
	{
		Schema::drop('vendors');
	}
}
