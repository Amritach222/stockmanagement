<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandsTable extends Migration {

	public function up()
	{
		Schema::create('brands', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 60);
			$table->integer('image_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('brands');
	}
}
