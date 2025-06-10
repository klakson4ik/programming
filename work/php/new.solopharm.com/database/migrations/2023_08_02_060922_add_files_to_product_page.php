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
        Schema::table('product_page', function (Blueprint $table) {
            $table->text('file_1')->nullable();
            $table->string('file_1_name')->nullable();
            $table->text('file_2')->nullable();
            $table->string('file_2_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_page', function (Blueprint $table) {
            $table->dropColumn('file_1');
            $table->dropColumn('file_1_name');
            $table->dropColumn('file_2');
            $table->dropColumn('file_2_name');
        });
    }
};
