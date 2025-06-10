<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tender_page', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('title')->nullable();
            $table->text('desc')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('img')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tender_page');
    }
};
