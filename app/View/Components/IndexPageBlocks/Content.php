<?php

namespace App\View\Components\IndexPageBlocks;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component
{
    public $pages;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->pages = Page::orderBy('sort')->get();
        return view('components.index-page-blocks.content', [
            'pages' => $this->pages
        ]);
    }
}
