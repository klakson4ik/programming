<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('value_pages', function (Blueprint $table) {
            $table->text('block_1_title')->nullable();
            $table->string('poster')->nullable();
			$table->string('youtube')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('value_pages', function (Blueprint $table) {
            $table->dropColumn('block_1_title');
            $table->dropColumn('poster');
            $table->dropColumn('youtube');
        });
    }
};
