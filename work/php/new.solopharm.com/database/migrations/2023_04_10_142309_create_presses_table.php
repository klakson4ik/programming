<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presses', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->string('img')->nullable();
            $table->text('title')->nullable()->fulltext();
            $table->text('description')->nullable();
            $table->string('tag')->nullable();
            $table->text('text')->nullable()->fulltext();
            $table->date('date')->nullable();
            $table->text('url_slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

	public function down()
    {
        Schema::dropIfExists('presses');
    }
};
