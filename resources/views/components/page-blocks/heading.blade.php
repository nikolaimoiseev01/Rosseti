{{-- Heading Block --}}
@php
    $level = $data['level'] ?? 'h2';
    $size = match($level) {
        'h1' => 'text-[64px] uppercase',
        'h2' => 'text-4xl uppercase',
        'h3' => 'text-2xl',
        'h4' => 'text-xl',
        default => 'text-3xl',
    };
    $fontWeight = match($data['font_weight'] ?? 'bold') {
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'semibold' => 'font-semibold',
        'bold' => 'font-bold',
        'extrabold' => 'font-extrabold',
        default => 'font-normal',
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
    $defaultColor = match($level) {
        'h1' => 'text-blue-900',
        'h2' => 'text-blue-500',
        'h3' => 'text-blue-500',
        'h4' => 'text-blue-500',
        default => 'text-blue-900',
    };
@endphp
<{{ $level }} class="page-block page-block--heading {{$data['color'] ?? $defaultColor}} {{ $size }} {{ $fontWeight }} {{ $spacingTop }} {{ $spacingBottom }}">{{ $data['content'] }}</{{ $level }}>
