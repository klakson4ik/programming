<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('solidplant_page', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('title')->nullable();
			$table->string('block_1_img')->nullable();
			$table->json('block_1_data')->nullable();
			$table->text('block_2_title')->nullable();
			$table->text('block_2_subtitle')->nullable();
			$table->text('block_3_title')->nullable();
			$table->text('block_3_desc')->nullable();
			$table->string('block_3_img')->nullable();
			$table->string('block_3_text')->nullable();
			$table->json('block_3_data_1')->nullable();
			$table->json('block_3_data_2')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('solidplant_page');
	}
};
