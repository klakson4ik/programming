<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('vacancy_page', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('title')->nullable();
			$table->text('block_1_title')->nullable();
			$table->text('block_1_desc')->nullable();
			$table->string('block_1_caption')->nullable();
			$table->string('block_1_url')->nullable();
			$table->string('block_1_img')->nullable();
			$table->text('block_2_title')->nullable();
			$table->text('block_2_desc')->nullable();
			$table->string('block_2_btn')->nullable();
			$table->string('block_2_action')->nullable();
			$table->text('url_slug')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('vacancy_page');
	}
};
