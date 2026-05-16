<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['Urgent', 'Penting', 'Opsional', 'Meeting', 'Ide'];

        foreach ($tags as $tag) {
            \App\Models\Tag::create(['name' => $tag]);
        }
    }
}
