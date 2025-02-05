<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlockType;

class BlockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BlockType::insert([
            [
                'type' => 'title',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'subtitle',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'description',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'list',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'code_block',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'screenshot',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'note',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'screenshot-gallery',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'tree',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'custom-link',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
