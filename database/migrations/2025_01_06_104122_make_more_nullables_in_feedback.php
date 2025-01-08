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
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->text('comment')->nullable()->change();
            $table->string('phoneNumber')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->text('comment')->nullable(false)->change();
            $table->string('phoneNumber')->nullable(false)->change();
        });
    }
};
