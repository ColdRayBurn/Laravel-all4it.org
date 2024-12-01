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
        Schema::create('homepage_info', function (Blueprint $table) {
            $table->id();
            $table->boolean('isActive')->default(true);
            $table->integer('sort')->default(500);

            //Main info
            $table->text('title');
            $table->text('description');
            $table->string('images');

            //advantages
            $table->string('advantages_title');
            $table->text('advantages_description')->nullable();

            //aboutus
            $table->string('aboutus_title');
            $table->text('aboutus_description');

            //pricelist
            $table->string('pricelist_title');
            $table->text('pricelist_description');

            //customers
            $table->string('customers_title')->nullable();
            $table->text('customers_description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_info');
    }
};
