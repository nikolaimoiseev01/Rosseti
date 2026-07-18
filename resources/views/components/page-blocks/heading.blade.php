{{-- Heading Block --}}
@php
    $level = $data['level'] ?? 'h2';
    $color = match($data['color'] ?? 'primary') {
        'primary' => 'text-[#00355A]',
        'accent' => 'text-[#2196F3]',
        'dark' => 'text-[#1A1A1A]',
        'white' => 'text-white',
        default => 'text-[#00355A]',
    };
    $size = match($level) {
        'h1' => 'text-5xl font-bold',
        'h2' => 'text-3xl font-bold',
        'h3' => 'text-2xl font-bold',
        'h4' => 'text-xl font-bold',
        default => 'text-3xl font-bold',
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
<{{ $level }} class="page-block page-block--heading {{ $size }} {{ $color }} {{ $spacingTop }} {{ $spacingBottom }}">{{ $data['content'] }}</{{ $level }}>
