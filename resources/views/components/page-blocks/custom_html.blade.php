{{-- Custom HTML Block --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
    $inGroup = $inGroup ?? false;
    $htmlContent = $data['html_content'] ?? '';
    $cssContent = $data['css_content'] ?? '';
    $htmlWidth = $data['html_width'] ?? '100';

    if ($inGroup) {
        $widthStyle = 'width: 100%';
    } else {
        $widthStyle = $htmlWidth !== '100' ? "max-width: {$htmlWidth}%" : 'width: 100%';
    }

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

    $scopeClass = 'custom-html-' . substr(md5($blockId), 0, 8);
@endphp

@if(!empty($htmlContent))
    @if(!empty($cssContent))
        <style>
            .{{ $scopeClass }} {
                {!! $cssContent !!}
            }
        </style>
    @endif

    <div id="{{ $blockId }}"
         x-data="revealOnScroll()"
         class="page-block page-block--custom-html {{ $scopeClass }} {{ $spacingTop }} {{ $spacingBottom }}"
         style="{{ $widthStyle }}"
    >
        {!! $htmlContent !!}
    </div>
@endif
