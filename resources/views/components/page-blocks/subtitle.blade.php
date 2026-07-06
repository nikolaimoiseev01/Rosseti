{{-- Subtitle Block --}}
@php
    $style = $data['style'] ?? 'default';
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
@endphp

@if($style === 'default')
    <p class="text-lg mb-2" style="color: #1A1A1A">{{ $data['text'] }}</p>

@elseif($style === 'accent')
    <p class="text-lg font-bold mb-2" style="color: {{ $colorHex }}">{{ $data['text'] }}</p>

@elseif($style === 'uppercase')
    <p class="text-sm uppercase tracking-[0.2em] font-bold mb-4" style="color: {{ $colorHex }}">{{ $data['text'] }}</p>
@endif
