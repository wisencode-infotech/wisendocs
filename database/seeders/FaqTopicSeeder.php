<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class FaqTopicSeeder extends Seeder
{
    public function run()
    {
        Topic::insert([
            ['name' => 'Introduction', 'slug' => 'introduction', 'version_id' => 1],
            ['name' => 'Installer', 'slug' => 'installer', 'version_id' => 1],
            ['name' => 'FAQs', 'slug' => 'faqs', 'version_id' => 1]
        ]);
    }
}
