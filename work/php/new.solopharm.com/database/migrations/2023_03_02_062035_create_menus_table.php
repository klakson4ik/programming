<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('lang')->default('ru');
            $table->unsignedInteger('sort')->default(500);
            $table->boolean('active');
            $table->string('name');
            $table->string('url');
            $table->unsignedBigInteger('parent_id')->nullable();
			$table->softDeletes();
            $table->timestamps();
        });
    }

	public function down()
    {
        Schema::dropIfExists('menus');
    }
};