<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('biotech_page', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->text('title')->nullable();
			$table->string('img')->nullable();
			$table->text('block_1_title')->nullable();
			$table->text('block_1_decs')->nullable();
			$table->json('block_1_data')->nullable();
			$table->text('block_2_title')->nullable();
			$table->text('block_2_tab_1')->nullable();
			$table->text('block_2_tab_2')->nullable();
			$table->json('block_2_data_1')->nullable();
			$table->json('block_2_data_2')->nullable();
			$table->text('block_3_title')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('biotech_page');
	}
};
