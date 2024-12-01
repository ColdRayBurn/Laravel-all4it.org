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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->boolean('isActive')->default(true);
            $table->integer('sort')->default(500);
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');

            $table->string('title');
            $table->string('image');
            $table->text('content');
            $table->dateTime('publishDatetime')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
