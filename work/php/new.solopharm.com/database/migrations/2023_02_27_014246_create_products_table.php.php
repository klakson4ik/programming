<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->unsignedInteger('sort')->default(500);
			$table->boolean('active');
			$table->boolean('can_buy');
			$table->boolean('novelty');
			$table->boolean('export');
			$table->boolean('CE');
			$table->string('img')->nullable();
			$table->string('title')->nullable()->fulltext();
			$table->unsignedBigInteger('direction_id')->nullable();
			$table->foreign('direction_id')
            ->references('id')->on('directions')->onDelete('set null')->nullable();
			$table->text('indications')->nullable()->fulltext();
			$table->text('scope')->nullable()->fulltext();
			$table->text('pharm')->nullable()->fulltext();
			$table->text('scope_pharm')->nullable()->fulltext();
			$table->text('compound')->nullable()->fulltext();
			$table->text('MNN')->nullable()->fulltext();
			$table->string('instruction')->nullable();
			$table->string('site')->nullable();
			$table->string('youtube')->nullable();
			$table->string('IQ_provision')->nullable();
			$table->text('url_slug')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('products');
	}
};
