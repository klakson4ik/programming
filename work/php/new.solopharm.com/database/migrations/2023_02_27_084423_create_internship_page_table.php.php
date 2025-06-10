<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('internship_page', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('title')->nullable();
			$table->text('desc')->nullable();
			$table->text('block_1_title')->nullable();
			$table->text('block_1_desc')->nullable();
			$table->string('block_1_img')->nullable();
			$table->text('block_2_title')->nullable();
			$table->text('block_2_desc')->nullable();
			$table->string('block_2_img')->nullable();
			$table->string('block_2_btn')->nullable();
			$table->string('block_2_action')->nullable();
			$table->text('block_3_title')->nullable();
			$table->text('block_3_desc')->nullable();
			$table->string('block_3_img')->nullable();
			$table->string('block_3_caption')->nullable();
			$table->string('block_3_url')->nullable();
			$table->json('form_directions')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('internship_page');
	}
};
