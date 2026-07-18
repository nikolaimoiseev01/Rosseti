<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class MigrateBlocksToLanguageFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:migrate-to-language-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing block data to new language format (ru/en structure) in data_languages column';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of block data to language format...');

        // Check if data_languages column exists
        if (!Schema::hasColumn('blocks', 'data_languages')) {
            $this->info('Creating data_languages column...');
            Schema::table('blocks', function (Blueprint $table) {
                $table->json('data_languages')->nullable()->after('data');
            });
            $this->info('Column created successfully.');
        }

        // Get all blocks
        $blocks = Block::all();
        $migratedCount = 0;
        $skippedCount = 0;

        $this->info("Processing {$blocks->count()} blocks...");

        foreach ($blocks as $block) {
            $data = $block->data;

            // Check if data_languages already has migrated data
            if (!empty($block->data_languages)) {
                $this->line("Block ID {$block->id} already has data_languages, skipping.");
                $skippedCount++;
                continue;
            }

            // Check if data is already in new format (has ru or en key)
            if (isset($data['ru']) || isset($data['en'])) {
                $this->line("Block ID {$block->id} data already in new format, copying to data_languages.");
                $block->data_languages = $data;
                $block->save();
                $migratedCount++;
                continue;
            }

            // Migrate to new format
            $newData = [
                'ru' => $data,
                'en' => $this->createEmptyStructure($data),
            ];

            // Preserve non-text fields at root level (excluding image-related fields)
            $nonTextFields = ['size', 'style', 'text_color', 'text_size', 'spacing', 'color', 'level', 'gap', 'header_style', 'items', 'events', 'steps', 'cards', 'headers', 'rows', 'codes'];

            foreach ($nonTextFields as $field) {
                if (isset($data[$field])) {
                    $newData[$field] = $data[$field];
                    unset($newData['ru'][$field]);
                }
            }

            // Handle image fields - move to ru structure
            $imageFields = ['url', 'photo', 'images', 'caption'];
            foreach ($imageFields as $field) {
                if (isset($data[$field])) {
                    $newData['ru'][$field] = $data[$field];
                    // Create empty structure for English
                    if ($field === 'images' && is_array($data[$field])) {
                        $newData['en'][$field] = [];
                    } else {
                        $newData['en'][$field] = '';
                    }
                }
            }

            $block->data_languages = $newData;
            $block->save();

            $this->line("Block ID {$block->id} migrated successfully.");
            $migratedCount++;
        }

        $this->info('Migration completed!');
        $this->info("Migrated: {$migratedCount} blocks");
        $this->info("Skipped: {$skippedCount} blocks");
        $this->info("Original data column remains unchanged");
        $this->info("Migrated data stored in 'data_languages' column");

        return Command::SUCCESS;
    }

    /**
     * Create empty structure for English version based on Russian structure
     */
    private function createEmptyStructure(array $russianData): array
    {
        $englishData = [];

        // Text fields that should have empty string in English
        $textFields = ['content', 'title', 'text', 'caption', 'description', 'name', 'position', 'author', 'codes', 'value'];

        foreach ($textFields as $field) {
            if (isset($russianData[$field])) {
                $englishData[$field] = '';
            }
        }

        // Array fields that should be empty arrays
        $arrayFields = ['items', 'events', 'steps', 'cards', 'images', 'headers', 'rows'];

        foreach ($arrayFields as $field) {
            if (isset($russianData[$field]) && is_array($russianData[$field])) {
                $englishData[$field] = [];
            }
        }

        return $englishData;
    }
}
