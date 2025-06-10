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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->boolean('show_in_main');
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->string('img')->nullable();
            $table->text('title')->nullable()->fulltext();
            $table->text('text')->nullable()->fulltext();
            $table->date('date')->nullable();
            $table->text('url_slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
