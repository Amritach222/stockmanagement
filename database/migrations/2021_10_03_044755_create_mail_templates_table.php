<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
//            $table->text('redirect_url')->nullable();
//            $table->string('footer_text')->nullable();
            $table->string('view_page')->nullable();
//            $table->boolean('has_redirect_url')->default(0);
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
        Schema::dropIfExists('mail_templates');
    }
}
