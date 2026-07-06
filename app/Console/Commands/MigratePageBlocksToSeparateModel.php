<?php

namespace App\Console\Commands;

use App\Models\Block;
use App\Models\Page;
use Illuminate\Console\Command;

class MigratePageBlocksToSeparateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:migrate-blocks
                            {--clear-old : Clear old content field after migration}
                            {--dry-run : Show what would be migrated without actually doing it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate page blocks from JSON content to separate Block model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $clearOld = $this->option('clear-old');

        $this->info('Starting migration of page blocks...');

        $pages = Page::whereNotNull('content')->where('content', '!=', '[]')->get();

        if ($pages->isEmpty()) {
            $this->info('No pages with content found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$pages->count()} pages with content.");

        $totalBlocks = 0;
        $migratedPages = 0;

        foreach ($pages as $page) {
            $content = $page->content;

            if (!is_array($content) || empty($content)) {
                $this->warn("Page ID {$page->id} ({$page->title}) has invalid or empty content. Skipping.");
                continue;
            }

            $this->info("Processing page: {$page->title} (ID: {$page->id})");
            $blockCount = count($content);
            $totalBlocks += $blockCount;

            if ($dryRun) {
                $this->line("  Would migrate {$blockCount} blocks:");
                foreach ($content as $index => $blockData) {
                    $type = $blockData['type'] ?? 'unknown';
                    $this->line("    - [{$index}] Type: {$type}");
                }
                $migratedPages++;
                continue;
            }

            // Migrate blocks
            foreach ($content as $index => $blockData) {
                $type = $blockData['type'] ?? 'unknown';
                $data = $blockData['data'] ?? [];

                Block::create([
                    'page_id' => $page->id,
                    'type' => $type,
                    'data' => $data,
                    'sort' => $index,
                ]);
            }

            if ($clearOld) {
                $page->content = null;
                $page->save();
                $this->line("  Migrated {$blockCount} blocks and cleared old content.");
            } else {
                $this->line("  Migrated {$blockCount} blocks (old content preserved).");
            }

            $migratedPages++;
        }

        $this->newLine();
        $this->info("Migration complete!");
        $this->info("Pages processed: {$migratedPages}");
        $this->info("Total blocks migrated: {$totalBlocks}");

        if ($dryRun) {
            $this->warn('This was a dry run. No changes were made.');
            $this->info('Run without --dry-run to actually migrate the data.');
        } else {
            if (!$clearOld) {
                $this->warn('Old content field was preserved. Run with --clear-old to remove it.');
            }
        }

        return Command::SUCCESS;
    }
}
