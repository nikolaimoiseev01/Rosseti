<?php

namespace App\View\Components;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public $navLinks = [];

    public $megaMenu = [];

    public function __construct()
    {
        $this->navLinks = Page::with('blocks')->orderBy('sort')->get();

        $locale = session('locale', 'ru');

        foreach ($this->navLinks as $page) {
            $headings = [];

            foreach ($page->blocks as $block) {
                if ($block->type !== 'heading') {
                    continue;
                }

                $rawData = !empty($block->data_languages) ? $block->data_languages : $block->data;

                if (!empty($rawData['ru']) && !empty($rawData['en'])) {
                    $data = array_merge($rawData[$locale] ?? [], $rawData);
                    unset($data['ru'], $data['en']);
                } elseif (isset($rawData[$locale])) {
                    $data = array_merge($rawData[$locale], $rawData);
                    unset($data['ru'], $data['en']);
                } else {
                    $data = $rawData;
                }

                if (($data['level'] ?? 'h2') !== 'h1') {
                    continue;
                }

                $title = trim(strip_tags($data['content'] ?? ''));

                if ($title === '') {
                    continue;
                }

                $headings[] = [
                    'title' => $title,
                    'anchor' => $page->id . '-' . $block->id,
                    'is_big' => !empty($data['is_big']),
                ];
            }

            $this->megaMenu[$page->slug] = [
                'headings' => $headings,
                'cover' => $page->coverUrl('cover_mobile', 'thumb')
                    ?: $page->coverUrl('cover', 'thumb'),
                'cover_extra' => $page->coverUrl('cover_extra', 'thumb'),
            ];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
