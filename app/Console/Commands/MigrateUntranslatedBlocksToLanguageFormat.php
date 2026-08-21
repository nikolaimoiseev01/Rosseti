<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;

class MigrateUntranslatedBlocksToLanguageFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:migrate-untranslated-to-language-format
                            {--dry-run : Show what would be changed without saving}
                            {--empty-en : Leave English content empty instead of copying Russian}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move flat content fields of key_figure, timeline and donut_chart blocks into ru/en language structure in data_languages';

    /**
     * Content keys that must live under ru/en, per block type.
     *
     * @var array<string, string[]>
     */
    private array $contentKeys = [
        'key_figure' => ['value', 'description', 'context'],
        'timeline' => ['title', 'events'],
        'donut_chart' => ['title', 'unit', 'value', 'prefix', 'suffix', 'description', 'center_value', 'center_label', 'segments'],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = (bool) $this->option('dry-run');
        $emptyEn = (bool) $this->option('empty-en');

        $this->info('Migrating key_figure / timeline / donut_chart blocks to ru/en format...');
        if ($dryRun) {
            $this->warn('DRY RUN — no changes will be saved.');
        }

        $blocks = Block::whereIn('type', array_keys($this->contentKeys))->get();

        $migrated = 0;
        $skipped = 0;

        foreach ($blocks as $block) {
            $dl = $block->data_languages;

            // Fall back to legacy `data` column if data_languages is empty
            if (empty($dl)) {
                $dl = $block->data;
            }

            if (empty($dl) || !is_array($dl)) {
                $this->line("Block ID {$block->id} ({$block->type}): no data, skipping.");
                $skipped++;
                continue;
            }

            $keys = $this->contentKeys[$block->type];

            // Collect flat content keys still present at top level
            $flat = [];
            foreach ($keys as $key) {
                if (array_key_exists($key, $dl)) {
                    $flat[$key] = $dl[$key];
                    unset($dl[$key]);
                }
            }

            if (empty($flat)) {
                $this->line("Block ID {$block->id} ({$block->type}): already in ru/en format, skipping.");
                $skipped++;
                continue;
            }

            // Merge into existing ru structure (top-level values win only if ru key is missing)
            $ru = is_array($dl['ru'] ?? null) ? $dl['ru'] : [];
            $dl['ru'] = array_merge($flat, $ru);

            // Build en structure: keep existing values, fill missing ones
            $en = is_array($dl['en'] ?? null) ? $dl['en'] : [];
            foreach ($flat as $key => $value) {
                if (isset($en[$key]) && $en[$key] !== '' && $en[$key] !== []) {
                    continue;
                }
                if ($emptyEn) {
                    $en[$key] = is_array($value) ? [] : '';
                } else {
                    $en[$key] = $value;
                }
            }
            $dl['en'] = $en;

            $movedKeys = implode(', ', array_keys($flat));
            $this->line("Block ID {$block->id} ({$block->type}): moved [{$movedKeys}] into ru/en.");

            if (!$dryRun) {
                $block->data_languages = $dl;
                $block->save();
            }

            $migrated++;
        }

        $this->info('Done.');
        $this->info("Migrated: {$migrated} blocks");
        $this->info("Skipped: {$skipped} blocks");
        if (!$emptyEn && $migrated > 0) {
            $this->info('English content was pre-filled with Russian values — translate it in the admin panel.');
        }

        return Command::SUCCESS;
    }
}
