<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class MigrateTableToLanguageFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:migrate-table-to-language-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing table block data to new language format (ru/en structure)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of table block data to language format...');

        // Check if data_languages column exists
        if (!Schema::hasColumn('blocks', 'data_languages')) {
            $this->error('data_languages column does not exist. Please run blocks:migrate-to-language-format first.');
            return Command::FAILURE;
        }

        // Get all table blocks
        $blocks = Block::where('type', 'table')->get();
        $migratedCount = 0;
        $skippedCount = 0;

        $this->info("Processing {$blocks->count()} table blocks...");

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

            // Check if has old format fields (headers and rows at root level)
            if (!isset($dataLanguages['headers']) && !isset($dataLanguages['rows'])) {
                $this->line("Block ID {$block->id} does not have old format fields, skipping.");
                $skippedCount++;
                continue;
            }

            // Migrate to new format
            $newData = [
                'ru' => [
                    'headers' => $dataLanguages['headers'] ?? [],
                    'rows' => $this->migrateRows($dataLanguages['rows'] ?? []),
                ],
                'en' => [
                    'headers' => [],
                    'rows' => [],
                ],
            ];

            // Preserve styling fields at root level
            $stylingFields = ['header_style', 'header_font_style', 'cell_padding', 'spacing_top', 'spacing_bottom'];
            foreach ($stylingFields as $field) {
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
        $this->info("Migrated: {$migratedCount} table blocks");
        $this->info("Skipped: {$skippedCount} table blocks");
        $this->info("Original data column remains unchanged");
        $this->info("Migrated data stored in 'data_languages' column");

        return Command::SUCCESS;
    }

    /**
     * Migrate rows preserving structure
     */
    private function migrateRows(array $rows): array
    {
        $migratedRows = [];

        foreach ($rows as $row) {
            $migratedRow = [
                'is_accent' => $row['is_accent'] ?? false,
            ];

            if (isset($row['accent_text'])) {
                $migratedRow['accent_text'] = $row['accent_text'];
            }

            if (isset($row['cells']) && is_array($row['cells'])) {
                $migratedRow['cells'] = $row['cells'];
            }

            $migratedRows[] = $migratedRow;
        }

        return $migratedRows;
    }
}
