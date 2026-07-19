<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;

class FixCardsGridFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:fix-cards-grid-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix malformed cards_grid data_languages structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting fix for cards_grid data_languages format...');

        $blocks = Block::where('type', 'cards_grid')
            ->whereNotNull('data_languages')
            ->where('data_languages', '!=', '[]')
            ->get();

        $count = 0;
        $skipped = 0;

        foreach ($blocks as $block) {
            $dataLanguages = $block->data_languages;

            // Check if this block has the malformed structure
            // Production format: {"en": {"cards": []}, "ru": {"columns": 3}, "cards": [...], "color": "accent"}
            if (!isset($dataLanguages['cards'])) {
                $skipped++;
                continue;
            }

            if (!isset($dataLanguages['ru']) || !is_array($dataLanguages['ru'])) {
                $skipped++;
                continue;
            }

            // Check if ru exists but doesn't have cards, and cards exists at top level
            if (isset($dataLanguages['ru']) && !isset($dataLanguages['ru']['cards']) && isset($dataLanguages['cards'])) {
                // Fix the structure
                $fixedDataLanguages = [
                    'en' => $dataLanguages['en'] ?? ['cards' => []],
                    'ru' => $dataLanguages['ru'],
                ];

                // Move top-level cards to ru.cards
                $fixedDataLanguages['ru']['cards'] = $dataLanguages['cards'];

                // Keep top-level settings (columns, color, title_size, logo_size, spacing)
                $settingsKeys = ['columns', 'color', 'title_size', 'logo_size', 'spacing'];
                foreach ($settingsKeys as $key) {
                    if (isset($dataLanguages[$key])) {
                        $fixedDataLanguages[$key] = $dataLanguages[$key];
                    }
                }

                // Remove the top-level cards key
                unset($fixedDataLanguages['cards']);

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

        $this->info("Successfully fixed {$count} cards_grid blocks.");
        $this->info("Skipped {$skipped} blocks already in correct format.");

        return 0;
    }
}
