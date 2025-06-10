<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('sites', function (Blueprint $table) {
			$table->id();
			$table->string('lang')->default('ru');
			$table->unsignedInteger('sort')->default(500);
			$table->boolean('active');
			$table->string('title')->nullable();
			$table->text('desc')->nullable();
			$table->string('img')->nullable();
			$table->text('text')->nullable();
			$table->string('btn')->nullable();
			$table->string('action')->nullable();

			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('sites');
	}
};
