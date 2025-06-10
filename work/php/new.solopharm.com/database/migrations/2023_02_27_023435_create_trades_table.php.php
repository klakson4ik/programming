<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->boolean('active');
            $table->boolean('is_main');
            $table->string('form')->nullable();
            $table->string('img')->nullable();
            $table->unsignedBigInteger('technology_id')->nullable();
            $table->foreign('technology_id')
                ->references('id')->on('technologies')->onDelete('set null')
                ->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')->on('products')->onDelete('set null')
                ->nullable();
            $table->text('url_slug')->nullable();
            $table->json('export_countries')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trades');
    }
};
