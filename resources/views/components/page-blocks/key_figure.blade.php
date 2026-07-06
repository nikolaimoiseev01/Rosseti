{{-- Key Figure Block --}}
@php
    $style = $data['style'] ?? 'card_blue';
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
@endphp

@if($style === 'card_blue')
    <div class="rounded-2xl p-8 flex flex-col justify-center min-h-[200px]" style="background-color: {{ $colorHex }}">
        @if(!empty($data['context']))
            <div class="text-sm leading-relaxed mb-4" style="color: #fff;">{!! $data['context'] !!}</div>
        @endif
        <p class="text-5xl font-bold mb-2" style="color: #fff;">{{ $data['value'] }}</p>
        <p class="text-sm" style="color: rgba(255,255,255,0.85);">{{ $data['description'] }}</p>
    </div>

@elseif($style === 'card_light')
    <div class="rounded-2xl bg-[#F7F9FC] border border-[#E1E7F0] p-8 flex flex-col justify-center min-h-[200px]">
        @if(!empty($data['context']))
            <div class="text-sm leading-relaxed mb-4" style="color: #333;">{!! $data['context'] !!}</div>
        @endif
        <p class="text-5xl font-bold mb-2" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <p class="text-sm" style="color: #6B7785;">{{ $data['description'] }}</p>
    </div>

@elseif($style === 'inline_large')
    <div class="text-center py-8 flex flex-col items-center justify-center">
        <p class="text-6xl font-bold mb-3" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <p class="text-lg" style="color: #6B7785;">{{ $data['description'] }}</p>
        @if(!empty($data['context']))
            <div class="text-sm leading-relaxed mt-4 max-w-xl mx-auto" style="color: #333;">{!! $data['context'] !!}</div>
        @endif
    </div>

@elseif($style === 'inline_left')
    <div class="flex items-center gap-8 py-4 lg:flex-col lg:items-start min-h-[80px]">
        <p class="text-5xl font-bold shrink-0" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <div>
            <p class="font-bold mb-1" style="color: #333;">{{ $data['description'] }}</p>
            @if(!empty($data['context']))
                <div class="text-sm leading-relaxed" style="color: #6B7785;">{!! $data['context'] !!}</div>
            @endif
        </div>
    </div>

@elseif($style === 'accent_border')
    <div class="border-l-4 pl-6 py-4 flex flex-col justify-center" style="border-color: {{ $colorHex }}">
        <p class="text-4xl font-bold mb-2" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <p class="font-bold" style="color: #333;">{{ $data['description'] }}</p>
        @if(!empty($data['context']))
            <div class="text-sm leading-relaxed mt-2" style="color: #6B7785;">{!! $data['context'] !!}</div>
        @endif
    </div>
@endif
