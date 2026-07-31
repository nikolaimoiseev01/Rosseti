<?php

namespace App\Helpers;

class BlockGrouper
{
    /**
     * Группирует блоки страницы в строки для CSS Grid.
     * Блоки с шириной < 100% автоматически объединяются в ряды,
     * если сумма ширин не превышает 100%.
     *
     * @param  \Illuminate\Support\Collection  $blocks
     * @param  string  $locale  'ru' или 'en'
     * @return array  Массив групп, каждая группа — массив элементов
     */
    public static function group($blocks, string $locale = 'ru'): array
    {
        $groupableTypes = ['chart', 'donut_chart', 'image', 'custom_html'];

        // --- Шаг 1: Обработка каждого блока ---
        $processed = [];
        foreach ($blocks as $block) {
            $rawData = !empty($block->data_languages) ? $block->data_languages : $block->data;

            // Локализация
            if (!empty($rawData['ru']) && !empty($rawData['en'])) {
                $ld = array_merge($rawData[$locale] ?? [], $rawData);
                unset($ld['ru'], $ld['en']);
            } elseif (isset($rawData[$locale])) {
                $ld = array_merge($rawData[$locale], $rawData);
                unset($ld['ru'], $ld['en']);
            } else {
                $ld = $rawData;
            }

            // Ширина блока в процентах
            $w = match ($block->type) {
                'chart'       => (int) ($ld['chart_width'] ?? 100),
                'donut_chart' => (int) ($ld['donut_width'] ?? 100),
                'image'       => match ($ld['image_width'] ?? $ld['size'] ?? '100') {
                    'full' => 100, 'large' => 75, 'medium' => 50,
                    default => (int) ($ld['image_width'] ?? 100),
                },
                'custom_html' => (int) ($ld['html_width'] ?? 100),
                default       => 100,
            };

            // Ширина → количество колонок (из 12)
            $span = match ($w) {
                33 => 4, 50 => 6, 66 => 8, 75 => 9,
                default => 12,
            };

            $processed[] = [
                'type'         => $block->type,
                'id'           => $block->id,
                'data'         => $ld,
                'span'         => $span,
                'preventMerge' => !empty($ld['prevent_merge']),
                'groupable'    => in_array($block->type, $groupableTypes) && $w < 100,
            ];
        }

        // --- Шаг 2: Группировка соседних блоков ---
        $groups   = [];
        $curGroup = [];
        $curCols  = 0;

        foreach ($processed as $pb) {
            $canGroup = $pb['groupable'] && !$pb['preventMerge'];

            if ($canGroup && ($curCols + $pb['span'] <= 12)) {
                $curGroup[] = $pb;
                $curCols   += $pb['span'];
            } else {
                if (!empty($curGroup)) {
                    $groups[] = $curGroup;
                }
                if ($canGroup) {
                    $curGroup = [$pb];
                    $curCols  = $pb['span'];
                } else {
                    $groups[] = [$pb];
                    $curGroup = [];
                    $curCols  = 0;
                }
            }
        }

        if (!empty($curGroup)) {
            $groups[] = $curGroup;
        }

        return $groups;
    }
}
