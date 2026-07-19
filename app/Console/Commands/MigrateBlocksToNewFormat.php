<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;

class MigrateBlocksToNewFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:migrate-data-languages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate blocks from old data_languages format to new format with language separation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of data_languages to new format...');

        $blocks = Block::whereNotNull('data_languages')
            ->where('data_languages', '!=', '[]')
            ->get();

        $count = 0;
        $skipped = 0;

        foreach ($blocks as $block) {
            $dataLanguages = $block->data_languages;

            // Check if already in new format (has 'ru' or 'en' keys)
            if (isset($dataLanguages['ru']) || isset($dataLanguages['en'])) {
                $skipped++;
                continue;
            }

            // Backup old data to 'data' field
            $block->data = $dataLanguages;

            // Create new data_languages structure with Russian data
            $newDataLanguages = [
                'ru' => $dataLanguages,
            ];

            // Update the block
            $block->data_languages = $newDataLanguages;
            $block->save();

            $count++;
        }

        if ($count === 0) {
            $this->info('No blocks found that need migration.');
            if ($skipped > 0) {
                $this->info("Skipped {$skipped} blocks already in new format.");
            }
            return 0;
        }

        $this->info("Successfully migrated {$count} blocks to new format.");
        $this->info('Old data has been backed up to data field.');
        $this->info("Skipped {$skipped} blocks already in new format.");

        return 0;
    }
}
