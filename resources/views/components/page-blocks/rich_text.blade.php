{{-- Rich Text Block with color and spacing --}}
@php
    $colorHex = match($data['text_color'] ?? 'default') {
        'primary' => '#00355A',
        'accent' => '#2196F3',
        'muted' => '#6B7785',
        'white' => '#FFFFFF',
        default => '#1A1A1A',
    };
    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '',
        'small' => 'mt-2',
        'normal' => 'mt-4',
        'large' => 'mt-8',
        'xl' => 'mt-12',
        '2xl' => 'mt-16',
        '3xl' => 'mt-24',
        default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '',
        'small' => 'mb-2',
        'normal' => 'mb-4',
        'large' => 'mb-8',
        'xl' => 'mb-12',
        '2xl' => 'mb-16',
        '3xl' => 'mb-24',
        default => 'mb-12',
    };
@endphp

<style>
    .rich-text-{{ $data['text_color'] ?? 'default' }} p,
    .rich-text-{{ $data['text_color'] ?? 'default' }} span,
    .rich-text-{{ $data['text_color'] ?? 'default' }} div {
        color: {{ $colorHex }} !important;
    }
</style>

<div class="page-block page-block--rich-text max-w-none {{ $spacingTop }} {{ $spacingBottom }} rich-text-{{ $data['text_color'] ?? 'default' }} [&_a]:text-[#2196F3] [&_a]:font-normal [&_a]:underline">
    {!! $data['content'] !!}
</div>
