<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;

class FixIconListFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:fix-icon-list-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix malformed icon_list data_languages structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting fix for icon_list data_languages format...');

        // Get all icon_list blocks
        $blocks = Block::where('type', 'icon_list')->get();

        $count = 0;
        $skipped = 0;

        foreach ($blocks as $block) {
            // Check if data_languages exists and is not empty
            if (!empty($block->data_languages)) {
                $dataLanguages = $block->data_languages;

                // Check if this is old format (items at root level, no ru/en structure)
                if (isset($dataLanguages['items']) && !isset($dataLanguages['ru'])) {
                    // Migrate from old format to new format
                    $fixedDataLanguages = [
                        'ru' => [
                            'items' => $dataLanguages['items'],
                        ],
                        'en' => [
                            'items' => [],
                        ],
                    ];

                    // Copy non-text fields to root level
                    $nonTextFields = ['icon_size', 'color', 'title_style', 'spacing_top', 'spacing_bottom'];
                    foreach ($nonTextFields as $field) {
                        if (isset($dataLanguages[$field])) {
                            $fixedDataLanguages[$field] = $dataLanguages[$field];
                        }
                    }

                    // Remove the top-level items key
                    unset($fixedDataLanguages['items']);

                    // Update the block
                    $block->data_languages = $fixedDataLanguages;
                    $block->save();

                    $count++;
                    $this->info("Migrated block ID: {$block->id} from old format");
                    continue;
                }

                // Check if this block has the malformed structure
                // Structure: {"en": {"items": []}, "ru": [], "items": [...]}
                if (!isset($dataLanguages['items'])) {
                    $skipped++;
                    continue;
                }

                if (!isset($dataLanguages['ru']) || !is_array($dataLanguages['ru'])) {
                    $skipped++;
                    continue;
                }

                // Check if ru is empty array and items exists at top level
                if (is_array($dataLanguages['ru']) && count($dataLanguages['ru']) === 0 && isset($dataLanguages['items'])) {
                    // Fix the structure
                    $fixedDataLanguages = [
                        'en' => $dataLanguages['en'] ?? ['items' => []],
                        'ru' => [
                            'items' => $dataLanguages['items'],
                        ],
                    ];

                    // Copy non-text fields to root level
                    $nonTextFields = ['icon_size', 'color', 'title_style', 'spacing_top', 'spacing_bottom'];
                    foreach ($nonTextFields as $field) {
                        if (isset($dataLanguages[$field])) {
                            $fixedDataLanguages[$field] = $dataLanguages[$field];
                        }
                    }

                    // Remove the top-level items key
                    unset($fixedDataLanguages['items']);

                    // Update the block
                    $block->data_languages = $fixedDataLanguages;
                    $block->save();

                    $count++;
                    $this->info("Fixed block ID: {$block->id}");
                } else {
                    $skipped++;
                }
            } else {
                // Migrate from old data column to data_languages
                $data = $block->data;
                
                if (empty($data) || !isset($data['items'])) {
                    $skipped++;
                    continue;
                }

                // Create new structure
                $newDataLanguages = [
                    'ru' => [
                        'items' => $data['items'],
                    ],
                    'en' => [
                        'items' => [],
                    ],
                ];

                // Copy non-text fields to root level
                $nonTextFields = ['icon_size', 'color', 'title_style', 'spacing_top', 'spacing_bottom'];
                foreach ($nonTextFields as $field) {
                    if (isset($data[$field])) {
                        $newDataLanguages[$field] = $data[$field];
                    }
                }

                $block->data_languages = $newDataLanguages;
                $block->save();

                $count++;
                $this->info("Migrated block ID: {$block->id} from old data column");
            }
        }

        if ($count === 0) {
            $this->info('No blocks found that need fixing/migrating.');
            if ($skipped > 0) {
                $this->info("Skipped {$skipped} blocks already in correct format.");
            }
            return 0;
        }

        $this->info("Successfully fixed/migrated {$count} icon_list blocks.");
        $this->info("Skipped {$skipped} blocks already in correct format.");

        return 0;
    }
}
