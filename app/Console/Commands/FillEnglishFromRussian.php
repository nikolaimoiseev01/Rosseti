<?php

namespace App\Console\Commands;

use App\Models\Block;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FillEnglishFromRussian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:fill-english-from-russian
                            {--dry-run : Show what would be changed without saving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill empty English versions of blocks with Russian content, duplicating image files for the English version';

    private bool $dryRun = false;

    private int $filesCopied = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->dryRun = (bool) $this->option('dry-run');

        if ($this->dryRun) {
            $this->warn('DRY RUN — no changes will be saved.');
        }

        $blocks = Block::all();

        $filled = 0;
        $skippedHasEn = 0;
        $skippedNoRu = 0;

        foreach ($blocks as $block) {
            $dl = $block->data_languages;

            if (empty($dl) || !is_array($dl)) {
                $skippedNoRu++;
                continue;
            }

            $ru = $dl['ru'] ?? null;

            if (!is_array($ru) || !$this->hasContent($ru)) {
                $this->line("Block ID {$block->id} ({$block->type}): no ru structure, skipping.");
                $skippedNoRu++;
                continue;
            }

            // 1) English version already exists — ignore
            if ($this->hasContent($dl['en'] ?? null)) {
                $skippedHasEn++;
                continue;
            }

            // 2) Copy Russian content into English, 3) duplicating image files
            $dl['en'] = $this->copyWithImages($ru);

            $this->line("Block ID {$block->id} ({$block->type}): English filled from Russian.");

            if (!$this->dryRun) {
                $block->data_languages = $dl;
                $block->save();
            }

            $filled++;
        }

        $this->info('Done.');
        $this->info("Filled: {$filled} blocks");
        $this->info("Skipped (English already exists): {$skippedHasEn} blocks");
        $this->info("Skipped (no ru structure / no data): {$skippedNoRu} blocks");
        $this->info("Image files copied: {$this->filesCopied}");

        return Command::SUCCESS;
    }

    /**
     * Check recursively whether a value contains any non-empty content.
     */
    private function hasContent(mixed $value): bool
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                if ($this->hasContent($item)) {
                    return true;
                }
            }

            return false;
        }

        if (is_string($value)) {
            return trim(strip_tags($value)) !== '';
        }

        return $value !== null && $value !== false;
    }

    /**
     * Deep copy an array, duplicating any referenced files on the public disk.
     */
    private function copyWithImages(array $data): array
    {
        $copy = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $copy[$key] = $this->copyWithImages($value);
            } elseif (is_string($value) && $this->isStoredFile($value)) {
                $copy[$key] = $this->duplicateFile($value);
            } else {
                $copy[$key] = $value;
            }
        }

        return $copy;
    }

    /**
     * Determine whether a string points to an existing file on the public disk.
     */
    private function isStoredFile(string $value): bool
    {
        if ($value === '' || strlen($value) > 500) {
            return false;
        }

        if (str_contains($value, '<') || str_contains($value, "\n")) {
            return false;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return false;
        }

        try {
            return Storage::disk('public')->exists($value) && !Storage::disk('public')->directoryExists($value);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Copy a file on the public disk and return the new path.
     */
    private function duplicateFile(string $path): string
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $stem = pathinfo($path, PATHINFO_FILENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $newPath = ($dir !== '.' && $dir !== '' ? $dir . '/' : '')
            . $stem . '-en-' . substr(md5(uniqid('', true)), 0, 6)
            . ($ext !== '' ? '.' . $ext : '');

        if (!$this->dryRun) {
            Storage::disk('public')->copy($path, $newPath);
        }

        $this->filesCopied++;
        $this->line("  copied file: {$path} -> {$newPath}");

        return $newPath;
    }
}
