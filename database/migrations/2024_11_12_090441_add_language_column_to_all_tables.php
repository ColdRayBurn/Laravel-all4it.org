<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('homepage_info', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        });
        Schema::table('advantages', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        });
        Schema::table('about_us_blocks', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        });
        Schema::table('pricings', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        });

        Schema::table('globals', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        });
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_info', function (Blueprint $table) {
            $table->dropForeign(['language_id']);  // Удаляем внешний ключ
            $table->dropColumn('language_id');     // Удаляем колонку
        });
        Schema::table('advantages', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
        });
        Schema::table('about_us_blocks', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
        });
        Schema::table('pricings', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
        });

        Schema::table('globals', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
        });
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
        });
    }
};
