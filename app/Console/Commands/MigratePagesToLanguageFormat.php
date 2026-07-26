<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class MigratePagesToLanguageFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:migrate-to-language-format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing page title data to new language format (ru/en structure)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of page title data to language format...');

        // Check if new columns exist
        if (!Schema::hasColumn('pages', 'title_languages') || !Schema::hasColumn('pages', 'title_page_languages')) {
            $this->error('title_languages or title_page_languages column does not exist. Please run migrations first.');
            return Command::FAILURE;
        }

        // Get all pages
        $pages = Page::all();
        $migratedCount = 0;
        $skippedCount = 0;

        $this->info("Processing {$pages->count()} pages...");

        foreach ($pages as $page) {
            // Check if already migrated (has ru or en key)
            if (!empty($page->title_languages) && (isset($page->title_languages['ru']) || isset($page->title_languages['en']))) {
                $this->line("Page ID {$page->id} already has title_languages in new format, skipping.");
                $skippedCount++;
                continue;
            }

            if (!empty($page->title_page_languages) && (isset($page->title_page_languages['ru']) || isset($page->title_page_languages['en']))) {
                $this->line("Page ID {$page->id} already has title_page_languages in new format, skipping.");
                $skippedCount++;
                continue;
            }

            // Migrate title
            $titleLanguages = [];
            if (!empty($page->title)) {
                $titleLanguages = [
                    'ru' => $page->title,
                    'en' => '',
                ];
            }

            // Migrate title_page
            $titlePageLanguages = [];
            if (!empty($page->title_page)) {
                $titlePageLanguages = [
                    'ru' => $page->title_page,
                    'en' => '',
                ];
            }

            // Update page if we have data to migrate
            if (!empty($titleLanguages) || !empty($titlePageLanguages)) {
                $page->title_languages = $titleLanguages;
                $page->title_page_languages = $titlePageLanguages;
                $page->save();

                $this->line("Page ID {$page->id} migrated successfully.");
                $migratedCount++;
            } else {
                $this->line("Page ID {$page->id} has no title data to migrate, skipping.");
                $skippedCount++;
            }
        }

        $this->info('Migration completed!');
        $this->info("Migrated: {$migratedCount} pages");
        $this->info("Skipped: {$skippedCount} pages");
        $this->info("Original title and title_page columns remain unchanged");
        $this->info("Migrated data stored in 'title_languages' and 'title_page_languages' columns");

        return Command::SUCCESS;
    }
}
