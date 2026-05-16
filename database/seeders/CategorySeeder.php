<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pekerjaan', 'color' => '#3b82f6'],
            ['name' => 'Kuliah', 'color' => '#8b5cf6'],
            ['name' => 'Personal', 'color' => '#10b981'],
            ['name' => 'Lainnya', 'color' => '#6b7280'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
