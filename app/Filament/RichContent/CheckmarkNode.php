<?php

namespace App\Filament\RichContent;

use Tiptap\Core\Node;
use Tiptap\Utils\HTML;

class CheckmarkNode extends Node
{
    public static $name = 'checkmark';

    public function parseHTML(): array
    {
        return [
            [
                'tag' => 'img[data-checkmark]',
            ],
        ];
    }

    public function renderHTML($node, $HTMLAttributes = []): array
    {
        return [
            'img',
            HTML::mergeAttributes(
                [
                    'src' => '/fixed/galochka.png',
                    'data-checkmark' => 'true',
                    'class' => 'table-check-icon',
                    'style' => 'width: 1.2em; height: 1.2em; display: inline-block; vertical-align: middle; margin: 0 4px;',
                    'alt' => '✓'
                ],
                $HTMLAttributes,
            ),
        ];
    }
}
