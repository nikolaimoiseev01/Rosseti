{{-- Icon List Block --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
    $currentLang = session('locale', 'ru');

    // Get language-specific data, fallback to old format
    $items = !empty($data[$currentLang]['items'])
        ? $data[$currentLang]['items']
        : ($data['items'] ?? []);

    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
    $iconSize = match($data['icon_size'] ?? 'medium') {
        'small' => 'w-6 h-6',
        'large' => 'w-[60px] h-[60px]',
        default => 'w-10 h-10',
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

    $styleClass = function($style) {
        return match($style) {
            'large_bold' => 'text-base font-bold text-[#1A1A1A]',
            'normal' => 'text-sm text-[#333]',
            'small' => 'text-xs text-[#333]',
            'accent' => 'text-base font-bold',
            'muted' => 'text-sm text-[#6B7785]',
            default => 'text-base font-bold text-[#1A1A1A]',
        };
    };
@endphp

<style>
    .page-block--icon-list img {
        margin: 0 !important;
    }

    .page-block--icon-list p {
        color: #1A1A1A !important;
    }

</style>
<div id="{{ $blockId }}" x-data="revealOnScroll()" class="page-block page-block--icon-list space-y-4 {{ $spacingTop }} {{ $spacingBottom }} [&_a]:text-[#2196F3] [&_a]:underline hover:[&_a]:text-[#005B9C]">
    @foreach($items as $item)
        @php
            $isTitleAccent = ($item['title_style'] ?? 'large_bold') === 'accent';
        @endphp
        <div class="flex items-start gap-4">
            @if(!empty($item['icon']))
                <img src="{{ Storage::url($item['icon']) }}" alt="" class="{{ $iconSize }} object-contain shrink-0 pointer-events-none">
            @endif
            <div style="color: #1A1A1A !important;" class="text-lg leading-6">
                {!! str_replace(['<p>', '</p>'], '', $item['title'] ?? '') !!}
                @if(!empty($item['text']))
                    <div class="mt-1 prose prose-sm max-w-none text-[#333]">{!! $item['text'] !!}</div>
                @endif
            </div>
        </div>
    @endforeach
</div>
