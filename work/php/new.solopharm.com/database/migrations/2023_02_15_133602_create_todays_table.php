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
        Schema::create('todays', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->text('title')->nullable();
            $table->string('img')->nullable();
            $table->text('text')->nullable();
            $table->string('slide_title')->nullable();
            $table->text('slide_text')->nullable();
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
        Schema::dropIfExists('todays');
    }
};
