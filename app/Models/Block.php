<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'data',
        'data_languages',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'data_languages' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($block) {
            if ($block->sort === null) {
                // If no sort specified, append to end
                $maxSort = static::where('page_id', $block->page_id)
                    ->max('sort');
                $block->sort = $maxSort !== null ? $maxSort + 1 : 0;
                return;
            }

            // Check if sort number already exists for this page
            $existingBlock = static::where('page_id', $block->page_id)
                ->where('sort', $block->sort)
                ->first();

            if ($existingBlock) {
                // Set new block's sort to existing sort + 1
                $block->sort = $block->sort + 1;

                // Shift all blocks with sort > original sort by +1
                static::where('page_id', $block->page_id)
                    ->where('sort', '>', $block->sort - 1)
                    ->increment('sort');
            }
        });
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
