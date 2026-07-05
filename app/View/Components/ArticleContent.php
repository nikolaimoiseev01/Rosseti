<?php

namespace App\View\Components;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticleContent extends Component
{
    public Page $page;
    /**
     * Create a new component instance.
     */
    public function __construct($page)
    {
        $this->page = $page;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.article-content');
    }
}
