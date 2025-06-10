<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('value_pages', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('title');
            $table->text('title_tooltip')->nullable();
            $table->text('block_2_title')->nullable();
            $table->string('block_2_btn_caption')->nullable();
            $table->string('block_2_btn_link')->nullable();
            $table->text('block_3_title')->nullable();
            $table->text('block_4_title')->nullable();
            $table->text('block_5_title')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('value_pages');
    }
};
