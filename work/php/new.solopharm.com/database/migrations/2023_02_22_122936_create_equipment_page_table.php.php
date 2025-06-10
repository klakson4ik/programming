<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('equipment_page', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('title')->nullable();
			$table->text('desc')->nullable();
			$table->text('text')->nullable();
			$table->text('block_1_title')->nullable();
			$table->text('block_1_text')->nullable();
			$table->text('block_2_text_1')->nullable();
			$table->text('block_2_text_2')->nullable();
			$table->text('block_2_text_3')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('equipment_page');
	}
};
