<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('contractual_page', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('title')->nullable();
			$table->text('desc')->nullable();
			$table->string('img')->nullable();
			$table->text('block_1_title')->nullable();
			$table->string('block_1_img')->nullable();
			$table->json('block_1_data')->nullable();
			$table->text('block_2_title')->nullable();
			$table->text('block_2_desc')->nullable();
			$table->json('block_2_data')->nullable();
			$table->string('block_2_img')->nullable();
			$table->text('block_3_title')->nullable();
			$table->text('block_3_desc')->nullable();
			$table->json('block_3_data')->nullable();
			$table->string('block_3_img')->nullable();
			$table->text('block_4_title')->nullable();
			$table->text('block_4_desc')->nullable();
			$table->string('block_4_img')->nullable();
			$table->string('btn_1')->nullable();
			$table->string('action_1')->nullable();
			$table->string('btn_2')->nullable();
			$table->string('action_2')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('contractual_page');
	}
};
