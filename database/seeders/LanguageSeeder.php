<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Language::create(['isActive' => true, 'code' => 'ru', 'name' => 'Русский']);
        \App\Models\Language::create(['isActive' => true, 'code' => 'en', 'name' => 'Английский']);
    }
}
