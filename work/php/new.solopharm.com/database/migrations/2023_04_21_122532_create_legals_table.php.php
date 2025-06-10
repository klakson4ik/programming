<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('legals', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->boolean('active');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('legal_site_id')->nullable();
            $table->foreign('legal_site_id')
                ->references('id')->on('legalsites')->onDelete('set null')
                ->nullable();
            $table->text('data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('legals');
    }
};
