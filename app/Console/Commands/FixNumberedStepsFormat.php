<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;

class FixNumberedStepsFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:fix-numbered-steps-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix malformed numbered_steps data_languages structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting fix for numbered_steps data_languages format...');

        $blocks = Block::where('type', 'numbered_steps')
            ->whereNotNull('data_languages')
            ->where('data_languages', '!=', '[]')
            ->get();

        $count = 0;
        $skipped = 0;

        foreach ($blocks as $block) {
            $dataLanguages = $block->data_languages;

            // Check if this block has the malformed structure
            // Structure: {"en": {"steps": []}, "ru": {"title": null}, "color": "accent", "steps": [...]}
            if (!isset($dataLanguages['steps'])) {
                $skipped++;
                continue;
            }

            if (!isset($dataLanguages['ru']) || !is_array($dataLanguages['ru'])) {
                $skipped++;
                continue;
            }

            // Check if ru exists but doesn't have steps, and steps exists at top level
            if (isset($dataLanguages['ru']) && !isset($dataLanguages['ru']['steps']) && isset($dataLanguages['steps'])) {
                // Fix the structure
                $fixedDataLanguages = [
                    'en' => $dataLanguages['en'] ?? ['title' => null, 'steps' => []],
                    'ru' => $dataLanguages['ru'],
                ];

                // Move top-level steps to ru.steps
                $fixedDataLanguages['ru']['steps'] = $dataLanguages['steps'];

                // Move top-level title to ru.title if it exists
                if (isset($dataLanguages['title'])) {
                    $fixedDataLanguages['ru']['title'] = $dataLanguages['title'];
                }

                // Keep top-level settings (color, icon_style, align, connected, etc.)
                $settingsKeys = ['color', 'icon_style', 'align', 'connected', 'spacing'];
                foreach ($settingsKeys as $key) {
                    if (isset($dataLanguages[$key])) {
                        $fixedDataLanguages[$key] = $dataLanguages[$key];
                    }
                }

                // Remove the top-level steps and title keys
                unset($fixedDataLanguages['steps']);
                unset($fixedDataLanguages['title']);

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

        $this->info("Successfully fixed {$count} numbered_steps blocks.");
        $this->info("Skipped {$skipped} blocks already in correct format.");

        return 0;
    }
}
