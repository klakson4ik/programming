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
        Schema::create('rnd_pages', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('desc')->nullable();
            $table->string('block_1_img')->nullable();
            $table->json('block_1_data')->nullable();
            $table->text('block_2_title')->nullable();
            $table->json('block_2_data')->nullable();
            $table->json('block_2_imgs')->nullable();
            $table->text('block_3_title')->nullable();
            $table->text('block_3_text')->nullable();
            $table->string('block_3_img')->nullable();
            $table->json('block_3_data')->nullable();
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
        Schema::dropIfExists('rnd_pages');
    }
};
