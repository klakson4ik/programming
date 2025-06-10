<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('labinternship_page', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('img')->nullable();
			$table->text('block_1_title')->nullable();
			$table->text('block_1_desc')->nullable();
			$table->string('block_1_subtitle')->nullable();
			$table->json('block_1_data')->nullable();
			$table->text('block_2_title')->nullable();
			$table->text('block_3_title')->nullable();
			$table->string('block_3_desc')->nullable();
			$table->string('block_3_btn')->nullable();
			$table->string('block_3_action')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('labinternship_page');
	}
};
