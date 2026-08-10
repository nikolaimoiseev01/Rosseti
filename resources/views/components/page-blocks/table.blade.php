{{-- Table Block --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
    $headerStyle = $data['header_style'] ?? 'blue';
    $cellPadding = match($data['cell_padding'] ?? 'normal') {
        'compact' => 'px-2 py-1',
        'spacious' => 'px-6 py-4',
        default => 'px-4 py-3',
    };
    $headerBgColor = match($headerStyle) {
        'blue' => '#00355A',
        'medium_blue' => '#005B9C',
        'brand_blue' => '#2196F3',
        'light' => '#F0F4F8',
        'grey' => '#E8EEF4',
        'light_blue' => '#EBF4FF',
        'dark' => '#1B2733',
        default => '',
    };
    $headerTextColor = match($data['header_text_color'] ?? 'white') {
        'white' => '#ffffff',
        'dark' => '#1A1A1A',
        'blue' => '#00355A',
        default => '#ffffff',
    };
    $headerFontStyle = match($data['header_font_style'] ?? 'bold') {
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'bold' => 'font-bold',
        default => 'font-bold',
    };
    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '',
        'small' => 'mt-2',
        'normal' => 'mt-4', 'medium' => 'mt-6',
        'large' => 'mt-8',
        'xl' => 'mt-12',
        '2xl' => 'mt-16',
        '3xl' => 'mt-24',
        default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '',
        'small' => 'mb-2',
        'normal' => 'mb-4', 'medium' => 'mb-6',
        'large' => 'mb-8',
        'xl' => 'mb-12',
        '2xl' => 'mb-16',
        '3xl' => 'mb-24',
        default => 'mb-12',
    };
    $colCount = count($data['headers'] ?? []);
    $tableUid = 'tbl-' . substr(md5($blockId), 0, 6);
@endphp

@if(!empty($data['caption']))
    <p class="text-lg font-bold text-[#00355A] mb-2">{!! $data['caption'] !!}</p>
@endif

<div id="{{ $blockId }}" x-data="revealOnScroll()" style="overflow: visible;" class="!overflow-visible page-block page-block--table overflow-x-auto rounded-xl border border-[#E1E7F0] {{ $spacingTop }} {{ $spacingBottom }}">
    <table class="w-full text-lg {{ $tableUid }}">
        @if(!empty($data['headers']))
            <thead>
                <tr @if($headerBgColor) style="background-color: {{ $headerBgColor }}" @endif>
                    @foreach($data['headers'] as $hIdx => $header)
                        <th class="{{ $cellPadding }} {{ $headerFontStyle }} text-left {{ !$loop->last ? 'border-r' : '' }}" style="color: {{ $headerTextColor }}; border-color: {{ in_array($headerStyle, ['blue', 'dark', 'medium_blue', 'brand_blue']) ? 'rgba(255,255,255,0.15)' : '#E1E7F0' }}">{!! $header['text'] !!}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @foreach($data['rows'] ?? [] as $index => $row)
                @if(!empty($row['is_accent']))
                    <tr>
                        <td colspan="{{ $colCount }}" class="bg-[#2196F3] text-white font-bold {{ $cellPadding }}">
                            {!! $row['accent_text'] ?? '' !!}
                        </td>
                    </tr>
                @else
                    @php
                        $rowColor = $row['row_color'] ?? '';
                        $isDarkRow = in_array($rowColor, ['#00355A', '#005B9C', '#2196F3']);
                        $rowBg = $rowColor ? '' : ($index % 2 === 0 ? 'bg-white' : 'bg-[#F7F9FC]');
                    @endphp
                    <tr class="{{ $tableUid }}-row {{ $rowBg }} {{ $isDarkRow ? $tableUid . '-dark-row' : '' }}"
                        @if($rowColor) style="background-color: {{ $rowColor }}" @endif
                    >
                        @foreach($row['cells'] ?? [] as $cell)
                            @php $cs = (int)($cell['colspan'] ?? 1); @endphp
                            <td class="{{ $cellPadding }} border-t border-[#E1E7F0] {{ !$loop->last ? 'border-r border-r-[#E1E7F0]' : '' }}" @if($cs > 1) colspan="{{ $cs }}" @endif>
                                <div class="prose prose-sm max-w-none">{!! $cell['text'] ?? '' !!}</div>
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* --- Header: force text color on all children (except inline-colored spans) --- */
    .{{ $tableUid }} thead th,
    .{{ $tableUid }} thead th *:not([style*="color"]):not([data-color]) {
        color: {{ $headerTextColor }} !important;
    }
    /* --- Default cell text color --- */
    .{{ $tableUid }} tbody td {
        color: #333;
    }
    /* --- Row hover --- */
    .{{ $tableUid }}-row {
        transition: background-color 0.25s ease, box-shadow 0.25s ease;
        cursor: default;
    }
    .{{ $tableUid }}-row:hover {
        background-color: #EBF4FF !important;
        box-shadow: inset 0 0 0 1px rgba(33, 150, 243, 0.12), 0 2px 8px rgba(0, 91, 156, 0.06);
    }
    .{{ $tableUid }}-row td {
        transition: color 0.25s ease;
    }
    .{{ $tableUid }}-row:hover td,
    .{{ $tableUid }}-row:hover td .prose,
    .{{ $tableUid }}-row:hover td .prose *:not([style*="color"]):not([data-color]) {
        color: #1A365D;
    }
    /* --- Dark row: white text --- */
    .{{ $tableUid }}-dark-row td,
    .{{ $tableUid }}-dark-row td .prose,
    .{{ $tableUid }}-dark-row td .prose *:not([style*="color"]):not([data-color]) {
        color: #fff !important;
    }
    .{{ $tableUid }}-dark-row:hover td,
    .{{ $tableUid }}-dark-row:hover td .prose,
    .{{ $tableUid }}-dark-row:hover td .prose *:not([style*="color"]):not([data-color]) {
        color: #E0E7EF !important;
    }
    .{{ $tableUid }}-dark-row:hover {
        filter: brightness(1.15);
        background-color: inherit !important;
    }
    /* --- Clean up RichEditor output inside table cells --- */
    .{{ $tableUid }} .prose p {
        margin: 0;
    }
    .{{ $tableUid }} .prose p + p {
        margin-top: 0.25em;
    }
    /* --- Inline text colors from RichEditor (uses CSS var --color) --- */
    .{{ $tableUid }} span[data-color],
    .{{ $tableUid }} span.color {
        color: var(--color) !important;
    }
    /* --- Links in table cells --- */
    .{{ $tableUid }} a {
        color: #2196F3 !important;
        font-weight: normal;
        text-decoration: underline;
    }
    .{{ $tableUid }}-row:hover td a,
    .{{ $tableUid }}-dark-row td a,
    .{{ $tableUid }}-dark-row:hover td a {
        color: #2196F3 !important;
    }
</style>
