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
        Schema::table('portfolio_items', function (Blueprint $table) {
            // Добавляем новые колонки
            $table->string('logotype'); // Логотип (ссылка на изображение)
            $table->text('shortDescription'); // Короткое описание
            $table->text('secondShortDescription'); // Второе короткое описание
            $table->string('url'); // Ссылка
            $table->date('developmentDate')->nullable();

            // Переименовываем колонку images в gallery
            $table->renameColumn('images', 'gallery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            // Удаляем новые колонки в случае отката миграции
            $table->dropColumn(['logotype', 'shortDescription', 'secondShortDescription', 'url', 'developmentDate']);

            // Откатываем изменения, переименовывая обратно
            $table->renameColumn('gallery', 'images');
        });
    }
};
