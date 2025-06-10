<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->boolean('active');
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->string('btn')->nullable();
            $table->string('file')->nullable();
            $table->string('coords')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->foreign('contact_id')
            ->references('id')->on('contacts')
            ->onDelete('set null')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
