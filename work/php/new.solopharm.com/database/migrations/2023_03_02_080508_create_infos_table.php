<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->text('address')->nullable();
            $table->text('address_url')->nullable();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->json('menu')->nullable();
            $table->boolean('is_vk');
            $table->boolean('is_youtube');
            $table->boolean('is_linkedin');
            $table->boolean('is_ok');
            $table->boolean('is_telegram');
            $table->boolean('is_zen');
            $table->boolean('is_iq');
            $table->string('vk_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('ok_url')->nullable();
            $table->string('telegram_url')->nullable();
            $table->string('zen_url')->nullable();
            $table->string('iq_url')->nullable();
			$table->softDeletes();
            $table->timestamps();
        });
    }

	public function down()
    {
        Schema::dropIfExists('infos');
    }
};