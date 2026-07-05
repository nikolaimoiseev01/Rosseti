<?php

namespace App\Livewire\Pages\Portal;

use App\Models\Page;
use Livewire\Component;

class ArticlePage extends Component
{
    public $page;

    public function render()
    {
        return view('livewire.pages.portal.article-page');
    }

    public function mount($slug) {
        $this->page = Page::where('slug', $slug)->first();
    }
}
