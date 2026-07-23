{{-- Info Block --}}
@php
    $style = $data['style'] ?? 'light';
    $textColor = $data['text_color'] ?? 'auto';
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

    $colorMap = [
        // Custom colors from tailwind.config.js
        'text-blue-300' => '#0C4EBB',
        'text-blue-400' => '#2196F3',
        'text-blue-500' => '#005A99',
        'text-blue-600' => '#00355A',
        'text-blue-700' => '#1B2733',
        'text-blue-900' => '#0E3A5C',
        'text-green-300' => '#009688',
        'text-black-100' => '#E1E7F0',
        'text-black-200' => '#c3c3c3',
        'text-black-300' => '#CDD6DE',
        'text-black-400' => '#6B7785',
        'text-black-500' => '#595959',
        'text-black-600' => '#F1F5FC',
        'text-black-900' => '#000000',
        'text-grey' => '#999999',
        'text-white' => '#FFFFFF',
    ];

    $cssColor = $textColor === 'auto' ? 'inherit' : ($colorMap[$textColor] ?? 'inherit');
    $uniqueId = 'info-block-' . uniqid();
@endphp

<style>
    [id^="info-block-"] * {
        color: var(--info-block-color) !important;
    }
</style>

@if($style === 'blue')
    <div id="{{ $uniqueId }}" class="page-block page-block--info-block rounded-2xl bg-blue-400 p-6 {{ $spacingTop }} {{ $spacingBottom }}" style="--info-block-color: {{ $cssColor }};">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'light')
    <div id="{{ $uniqueId }}" class="page-block page-block--info-block rounded-2xl bg-[#F0F5FA] p-6 {{ $spacingTop }} {{ $spacingBottom }}" style="--info-block-color: {{ $cssColor }};">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'accent')
    <div id="{{ $uniqueId }}" class="page-block page-block--info-block border-l-4 border-[#2196F3] bg-[#F7F9FC] rounded-2xl p-6 {{ $spacingTop }} {{ $spacingBottom }}" style="--info-block-color: {{ $cssColor }};">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'dark')
    <div id="{{ $uniqueId }}" class="page-block page-block--info-block rounded-2xl bg-[#1B2733] p-6 {{ $spacingTop }} {{ $spacingBottom }}" style="--info-block-color: {{ $cssColor }};">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'bordered')
    <div id="{{ $uniqueId }}" class="page-block page-block--info-block rounded-2xl bg-white border border-gray-200 p-6 {{ $spacingTop }} {{ $spacingBottom }}" style="--info-block-color: {{ $cssColor }};">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>
@endif
