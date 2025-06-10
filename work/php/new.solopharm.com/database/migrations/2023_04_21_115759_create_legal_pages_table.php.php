<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('legal_pages', function (Blueprint $table) {
            $table->id();
			$table->string('lang')->default('ru');
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('title')->nullable();

			$table->softDeletes();
            $table->timestamps();
        });
    }

	public function down()
    {
        Schema::dropIfExists('legal_pages');
    }
};