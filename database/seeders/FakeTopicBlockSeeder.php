<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TopicBlock;

class FaqTopicBlockSeeder extends Seeder
{
    public function run()
    {
        TopicBlock::insert([
            // Introduction Blocks
            [
                'topic_id' => 1,
                'block_type_id' => 1,
                'attributes' => json_encode(['text' => 'Welcome to the Document Generator!']),
                'order' => 1,
                'start_content_level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'topic_id' => 1,
                'block_type_id' => 7,
                'attributes' => json_encode([
                    'type' => 'info',
                    'title' => 'Overview',
                    'icon' => 'fa-solid fa-file-alt',
                    'text' => 'This guide will help you create, manage, and customize document templates easily.'
                ]),
                'order' => 2,
                'start_content_level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Installer Blocks
            [
                'topic_id' => 2,
                'block_type_id' => 1,
                'attributes' => json_encode(['text' => 'Our system provides various pre-built document templates.']),
                'order' => 1,
                'start_content_level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'topic_id' => 2,
                'block_type_id' => 4,
                'attributes' => json_encode(['list' => ["Invoice", "Contract", "Report", "Resume"]]),
                'order' => 2,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // FAQs Blocks
            [
                'topic_id' => 3,
                'block_type_id' => 1,
                'attributes' => json_encode(['text' => 'General']),
                'order' => 1,
                'start_content_level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 2,
                'attributes' => json_encode(['text' => 'What is Document Generator?']),
                'order' => 2,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 3,
                'attributes' => json_encode(['text' => 'Document Generator is a powerful tool that allows users to create, edit, and manage professional documents with ease.']),
                'order' => 3,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 2,
                'attributes' => json_encode(['text' => 'Who can use Document Generator?']),
                'order' => 4,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 3,
                'attributes' => json_encode(['text' => 'It is suitable for businesses, professionals, and individuals who need to generate structured documents efficiently.']),
                'order' => 5,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 7,
                'attributes' => json_encode(['type' => 'info', 'title' => 'System Requirements', 'icon' => 'fa-solid fa-list', 'text' => '<ul><li>PHP 8.1 or higher</li><li>MySQL 8.0 or higher</li><li>Node.js 16 or higher</li><li>Composer 2.x</li></ul>']),
                'order' => 6,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 1,
                'attributes' => json_encode(['text' => 'Advanced']),
                'order' => 7,
                'start_content_level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 2,
                'attributes' => json_encode(['text' => 'Can I generate PDF documents?']),
                'order' => 8,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 3,
                'attributes' => json_encode(['text' => 'Yes, Document Generator supports exporting documents to PDF format for professional use.']),
                'order' => 9,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 1,
                'attributes' => json_encode(['text' => 'Support']),
                'order' => 10,
                'start_content_level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 2,
                'attributes' => json_encode(['text' => 'Where can I get help with Document Generator?']),
                'order' => 11,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'topic_id' => 3,
                'block_type_id' => 7,
                'attributes' => json_encode(['type' => 'warning', 'title' => 'Support Options', 'icon' => 'fa-solid fa-list', 'text' => '<ul><li>Official documentation</li><li>Community forums</li><li>Email support: support@documentgenerator.com</li></ul>']),
                'order' => 12,
                'start_content_level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
