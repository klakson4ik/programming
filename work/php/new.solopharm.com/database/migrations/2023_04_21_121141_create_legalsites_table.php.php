<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('legalsites', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->boolean('active');
            $table->text('title')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('legalsites');
    }
};
