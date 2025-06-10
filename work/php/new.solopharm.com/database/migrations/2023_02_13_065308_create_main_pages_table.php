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
        Schema::create('main_pages', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('block_1_title')->nullable();
            $table->string('block_1_text_1')->nullable();
            $table->string('block_1_text_2')->nullable();
            $table->string('block_1_img')->nullable();
            $table->string('block_2_title')->nullable();
            $table->string('block_2_description')->nullable();
            $table->string('block_2_btn_caption')->nullable();
            $table->string('block_2_btn_link')->nullable();
            $table->json('block_2_text')->nullable();
            $table->string('block_3_title')->nullable();
            $table->string('block_4_title')->nullable();
            $table->string('block_4_url_caption')->nullable();
            $table->string('block_4_url_link')->nullable();
            $table->string('block_5_title')->nullable();
            $table->string('block_5_url_caption')->nullable();
            $table->string('block_5_url_link')->nullable();
            $table->string('block_6_title')->nullable();
            $table->text('block_6_text')->nullable();
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
        Schema::dropIfExists('main_pages');
    }
};
