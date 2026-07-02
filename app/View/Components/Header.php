<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public array $navLinks = [];

    public function __construct()
    {
        $this->navLinks = [
            ['title' => 'О компании', 'href' => '#about'],
            ['title' => 'Управление устойчивым развитием', 'href' => '#sustainability'],
            ['title' => 'Вклад в развитие страны', 'href' => '#impact'],
            ['title' => 'Забота об окружающей среде', 'href' => '#environment'],
            ['title' => 'Защита прав человека', 'href' => '#human-rights'],
            ['title' => 'Вклад в общество', 'href' => '#society'],
            ['title' => 'Управленческий аспект', 'href' => '#management'],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
