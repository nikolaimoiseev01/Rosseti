<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'slug',
        'title',
        'title_page',
        'title_languages',
        'title_page_languages',
        'content',
        'is_active',
        'sort',
        'description',
        'cover_height'
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'title_languages' => 'array',
            'title_page_languages' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class)->orderBy('sort');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->nonQueued();
    }

    public function coverUrl(string $collection, string $conversion = '', ?string $locale = null): string
    {
        $locale = $locale ?? session('locale', 'ru');

        if ($locale !== 'ru') {
            $url = $this->getFirstMediaUrl("{$collection}_{$locale}", $conversion)
                ?: $this->getFirstMediaUrl("{$collection}_{$locale}");

            if ($url !== '') {
                return $url;
            }
        }

        return $this->getFirstMediaUrl($collection, $conversion)
            ?: $this->getFirstMediaUrl($collection);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
