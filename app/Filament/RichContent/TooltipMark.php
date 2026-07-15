<?php

namespace App\Filament\RichContent;

use Tiptap\Core\Mark;
use Tiptap\Utils\HTML;

class TooltipMark extends Mark
{
    public static $name = 'tooltip';

    public function parseHTML(): array
    {
        return [
            [
                'tag' => 'span[data-tooltip]',
            ],
        ];
    }

    public function addAttributes(): array
    {
        return [
            'text' => [
                'default' => null,

                'parseHTML' => static function ($element): ?string {
                    $text = $element->getAttribute('data-tooltip');

                    return $text !== ''
                        ? $text
                        : null;
                },

                'renderHTML' => static function ($attributes): array {
                    $text = $attributes->text ?? null;

                    if (blank($text)) {
                        return [];
                    }

                    return [
                        'data-tooltip' => $text,
                        'aria-label' => $text,
                        'tabindex' => '0',
                    ];
                },
            ],
        ];
    }

    public function renderHTML(
        $mark,
        $HTMLAttributes = [],
    ): array {
        return [
            'span',
            HTML::mergeAttributes(
                [
                    'class' => 'has-tooltip',
                ],
                $HTMLAttributes,
            ),
            0,
        ];
    }
}
