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
        Schema::create('privacy', function (Blueprint $table) {
            $table->id();
            $table->boolean('isActive')->default(true);
            $table->integer('sort')->default(500);
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');

            $table->text('content');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacy');
    }
};
