{{-- Subtitle Block --}}
@php
    $style = $data['style'] ?? 'default';
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
@endphp

@if($style === 'default')
    <p class="text-lg mb-2" style="color: {{ $colorHex }}80">{{ $data['text'] }}</p>

@elseif($style === 'accent')
    <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-[3px] rounded-full" style="background-color: {{ $colorHex }}"></div>
        <p class="text-lg font-bold" style="color: {{ $colorHex }}">{{ $data['text'] }}</p>
    </div>

@elseif($style === 'uppercase')
    <p class="text-sm uppercase tracking-[0.2em] font-bold mb-4" style="color: {{ $colorHex }}">{{ $data['text'] }}</p>
@endif
