<?php

namespace Database\Seeders;

use App\Models\BlockAttribute;
use Illuminate\Database\Seeder;

class BlockAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $blockAttributes = [
            ['block_type' => 1, 'attributes' => [['label' => 'Text', 'name' => 'attributes[text]', 'type' => 'textarea']]],
            ['block_type' => 2, 'attributes' => [['label' => 'Text', 'name' => 'attributes[text]', 'type' => 'textarea']]],
            ['block_type' => 3, 'attributes' => [['label' => 'Text', 'name' => 'attributes[text]', 'type' => 'textarea']]],
            ['block_type' => 4, 'attributes' => [['label' => 'List Items', 'name' => 'attributes[list]', 'type' => 'textarea', 'placeholder' => 'Enter items separated by commas']]],
            ['block_type' => 5, 'attributes' => [
                ['label' => 'Code', 'name' => 'attributes[code]', 'type' => 'textarea', 'placeholder' => 'Enter code here'],
                ['label' => 'Language', 'name' => 'attributes[language]', 'type' => 'text', 'placeholder' => 'e.g., PHP, JavaScript'],
                ['label' => 'Copy Button Text', 'name' => 'attributes[copy_btn_text]', 'type' => 'text', 'placeholder' => 'Copy'],
                ['label' => 'Copy Content', 'name' => 'attributes[copy_content]', 'type' => 'textarea', 'placeholder' => 'Code to be copied']
            ]],
            ['block_type' => 6, 'attributes' => [
                ['label' => 'Title', 'name' => 'attributes[title]', 'type' => 'text'],
                ['label' => 'Description', 'name' => 'attributes[description]', 'type' => 'textarea'],
                ['label' => 'Image URL', 'name' => 'attributes[imageUrl]', 'type' => 'text']
            ]],
            ['block_type' => 7, 'attributes' => [
                ['label' => 'Type', 'name' => 'attributes[type]', 'type' => 'text'],
                ['label' => 'Title', 'name' => 'attributes[title]', 'type' => 'text'],
                ['label' => 'Icon', 'name' => 'attributes[icon]', 'type' => 'text'],
                ['label' => 'Text', 'name' => 'attributes[text]', 'type' => 'textarea']
            ]],
            ['block_type' => 8, 'attributes' => [
                ['label' => 'Image Title', 'name' => 'attributes[images][0][title]', 'type' => 'text'],
                ['label' => 'Image Description', 'name' => 'attributes[images][0][description]', 'type' => 'textarea'],
                ['label' => 'Image URL', 'name' => 'attributes[images][0][imageUrl]', 'type' => 'text']
            ]],
            ['block_type' => 9, 'attributes' => [['label' => 'Text', 'name' => 'attributes[text]', 'type' => 'textarea']]],
            // [
            //     'block_type' => 'tree',
            //     'attributes' => [
            //         [
            //             'label' => 'Structure (Enter hierarchical structure like below.)',
            //             'name' => 'attributes[tree]',
            //             'type' => 'textarea',
            //             'placeholder' => json_encode([
            //                 "nodes" => [
            //                     [
            //                         "label" => "public/assets/frontend/css/",
            //                         "icon"  => "fa-regular fa-folder",
            //                         "children" => [
            //                             [
            //                                 "label" => "theme-1",
            //                                 "icon"  => "fa-regular fa-folder",
            //                                 "children" => [
            //                                     ["label" => "style-1.css", "icon" => "fa fa-file-code"],
            //                                     ["label" => "style-2.css", "icon" => "fa fa-file-code"],
            //                                     ["label" => "style-3.css", "icon" => "fa fa-file-code"],
            //                                 ]
            //                             ],
            //                             [
            //                                 "label" => "theme-2",
            //                                 "icon"  => "fa-regular fa-folder",
            //                                 "children" => [
            //                                     ["label" => "style-1.css", "icon" => "fa fa-file-code"],
            //                                     ["label" => "style-2.css", "icon" => "fa fa-file-code"],
            //                                     ["label" => "style-3.css", "icon" => "fa fa-file-code"],
            //                                 ]
            //                             ]
            //                         ]
            //                     ],
            //                     [
            //                         "label" => "public/assets/frontend/js/",
            //                         "icon"  => "fa-regular fa-folder",
            //                         "children" => [
            //                             [
            //                                 "label" => "theme-1",
            //                                 "icon"  => "fa-regular fa-folder",
            //                                 "children" => [
            //                                     ["label" => "script-1.js", "icon" => "fa-brands fa-js"],
            //                                     ["label" => "script-2.js", "icon" => "fa-brands fa-js"],
            //                                     ["label" => "script-3.js", "icon" => "fa-brands fa-js"],
            //                                 ]
            //                             ],
            //                             [
            //                                 "label" => "theme-2",
            //                                 "icon"  => "fa-regular fa-folder",
            //                                 "children" => [
            //                                     ["label" => "script-1.js", "icon" => "fa-brands fa-js"],
            //                                     ["label" => "script-2.js", "icon" => "fa-brands fa-js"],
            //                                     ["label" => "script-3.js", "icon" => "fa-brands fa-js"],
            //                                 ]
            //                             ]
            //                         ]
            //                     ]
            //                 ]
            //             ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            //         ]
            //     ]
            // ],
            ['block_type' => 10, 'attributes' => [
                ['label' => 'URL', 'name' => 'attributes[url]', 'type' => 'text', 'value' => rtrim(env('APP_URL'), '/') . '/terminal-commands/blocks/96'],
                ['label' => 'Title', 'name' => 'attributes[title]', 'type' => 'text', 'value' => 'Click here to know more about create site theme command'],
                ['label' => 'Icon', 'name' => 'attributes[icon]', 'type' => 'text', 'value' => 'fa fa-info-circle'],
                ['label' => 'Underline', 'name' => 'attributes[underline]', 'type' => 'checkbox', 'value' => true],
                ['label' => 'Title', 'name' => 'attributes[title]', 'type' => 'text', 'value' => 'Click here to know more about create site theme command'],
                ['label' => 'CSS Classes', 'name' => 'attributes[classes]', 'type' => 'text', 'value' => 'p-1 text-theme-dark dark:text-theme-light hover:text-gray-500 text-sm']
            ]]
        ];

        foreach ($blockAttributes as $attribute) {
            BlockAttribute::updateOrCreate(
                ['block_type' => $attribute['block_type']], // Condition to check if already exists
                ['attributes' => $attribute['attributes']]
            );
        }
    }
}
