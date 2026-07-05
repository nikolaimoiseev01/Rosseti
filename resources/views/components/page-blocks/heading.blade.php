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
        'h2' => 'text-3xl font-bold',
        'h3' => 'text-2xl font-bold',
        'h4' => 'text-xl font-bold',
        default => 'text-3xl font-bold',
    };
@endphp
<{{ $level }} class="{{ $size }} {{ $color }}">{{ $data['content'] }}</{{ $level }}>
