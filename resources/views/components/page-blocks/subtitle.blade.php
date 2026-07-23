{{-- Subtitle Block --}}
@php
    $style = $data['style'] ?? 'default';
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
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
@endphp

@if($style === 'default')
    <p x-data="revealOnScroll()" class="page-block page-block--subtitle text-lg {{ $spacingTop }} {{ $spacingBottom }}" style="color: #1A1A1A">{{ $data['text'] }}</p>

@elseif($style === 'accent')
    <p x-data="revealOnScroll()" class="page-block page-block--subtitle text-lg {{ $spacingTop }} {{ $spacingBottom }}" style="color: {{ $colorHex }}">{{ $data['text'] }}</p>

@elseif($style === 'uppercase')
    <p x-data="revealOnScroll()" class="page-block page-block--subtitle text-sm uppercase tracking-[0.2em] font-bold {{ $spacingTop }} {{ $spacingBottom }}" style="color: {{ $colorHex }}">{{ $data['text'] }}</p>
@endif
