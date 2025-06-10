<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->boolean('active');
            $table->string('title')->nullable();
            $table->string('img')->nullable();
            $table->text('office')->nullable();
            $table->json('data')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
