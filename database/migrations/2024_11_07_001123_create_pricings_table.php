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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->boolean('isActive')->default(true);
            $table->integer('sort')->default(500);

            $table->string('title');
            $table->integer('priceFrom');
            $table->string('time');
            $table->text('description');
            $table->boolean('isHighlighted');

            $table->timestamps();             // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
