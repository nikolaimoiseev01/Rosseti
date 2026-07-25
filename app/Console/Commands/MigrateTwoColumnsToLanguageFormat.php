<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class MigrateTwoColumnsToLanguageFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:migrate-two-columns-to-language-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing two_columns block data to new language format (ru/en structure)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of two_columns block data to language format...');

        // Check if data_languages column exists
        if (!Schema::hasColumn('blocks', 'data_languages')) {
            $this->error('data_languages column does not exist. Please run blocks:migrate-to-language-format first.');
            return Command::FAILURE;
        }

        // Get all two_columns blocks
        $blocks = Block::where('type', 'two_columns')->get();
        $migratedCount = 0;
        $skippedCount = 0;

        $this->info("Processing {$blocks->count()} two_columns blocks...");

        foreach ($blocks as $block) {
            $dataLanguages = $block->data_languages;

            // Check if data_languages is empty
            if (empty($dataLanguages)) {
                $this->line("Block ID {$block->id} has empty data_languages, skipping.");
                $skippedCount++;
                continue;
            }

            // Check if already in new format (has ru or en key)
            if (isset($dataLanguages['ru']) || isset($dataLanguages['en'])) {
                $this->line("Block ID {$block->id} already in new format, skipping.");
                $skippedCount++;
                continue;
            }

            // Check if has old format fields (left and right at root level)
            if (!isset($dataLanguages['left']) && !isset($dataLanguages['right'])) {
                $this->line("Block ID {$block->id} does not have old format fields, skipping.");
                $skippedCount++;
                continue;
            }

            // Migrate to new format
            $newData = [
                'ru' => [
                    'left' => $dataLanguages['left'] ?? '',
                    'right' => $dataLanguages['right'] ?? '',
                ],
                'en' => [
                    'left' => '',
                    'right' => '',
                ],
            ];

            // Preserve spacing fields at root level
            $spacingFields = ['spacing_top', 'spacing_bottom'];
            foreach ($spacingFields as $field) {
                if (isset($dataLanguages[$field])) {
                    $newData[$field] = $dataLanguages[$field];
                }
            }

            $block->data_languages = $newData;
            $block->save();

            $this->line("Block ID {$block->id} migrated successfully.");
            $migratedCount++;
        }

        $this->info('Migration completed!');
        $this->info("Migrated: {$migratedCount} two_columns blocks");
        $this->info("Skipped: {$skippedCount} two_columns blocks");
        $this->info("Original data column remains unchanged");
        $this->info("Migrated data stored in 'data_languages' column");

        return Command::SUCCESS;
    }
}
