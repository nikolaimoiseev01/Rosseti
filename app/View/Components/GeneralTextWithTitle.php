<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GeneralTextWithTitle extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $text;
    public $gri;

    public function __construct($title, $text, $gri=null)
    {
        $this->title = $title;
        $this->text = $text;
        $this->gri = $gri;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.general-text-with-title');
    }
}
