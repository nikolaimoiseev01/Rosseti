<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;

class FixStatsGridFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:fix-stats-grid-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix malformed stats_grid data_languages structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting fix for stats_grid data_languages format...');

        $blocks = Block::where('type', 'stats_grid')
            ->whereNotNull('data_languages')
            ->where('data_languages', '!=', '[]')
            ->get();

        $count = 0;
        $skipped = 0;

        foreach ($blocks as $block) {
            $dataLanguages = $block->data_languages;

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
        }

        if ($count === 0) {
            $this->info('No blocks found that need fixing.');
            if ($skipped > 0) {
                $this->info("Skipped {$skipped} blocks already in correct format.");
            }
            return 0;
        }

        $this->info("Successfully fixed {$count} stats_grid blocks.");
        $this->info("Skipped {$skipped} blocks already in correct format.");

        return 0;
    }
}
