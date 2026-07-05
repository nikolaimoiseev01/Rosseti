{{-- Key Figure Block --}}
@php
    $style = $data['style'] ?? 'card_blue';
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
@endphp

@if($style === 'card_blue')
    <div class="rounded-2xl p-8 flex flex-col justify-between min-h-[200px]" style="background-color: {{ $colorHex }}">
        @if(!empty($data['context']))
            <div class="text-white/80 text-sm leading-relaxed mb-4">{!! $data['context'] !!}</div>
        @endif
        <div>
            <p class="text-5xl font-bold text-white mb-2">{{ $data['value'] }}</p>
            <p class="text-white/70 text-sm">{{ $data['description'] }}</p>
        </div>
    </div>

@elseif($style === 'card_light')
    <div class="rounded-2xl bg-[#F7F9FC] border border-[#E1E7F0] p-8 flex flex-col justify-between min-h-[200px]">
        @if(!empty($data['context']))
            <div class="text-[#333] text-sm leading-relaxed mb-4">{!! $data['context'] !!}</div>
        @endif
        <div>
            <p class="text-5xl font-bold mb-2" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
            <p class="text-[#6B7785] text-sm">{{ $data['description'] }}</p>
        </div>
    </div>

@elseif($style === 'inline_large')
    <div class="text-center py-8">
        <p class="text-6xl font-bold mb-3" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <p class="text-[#6B7785] text-lg">{{ $data['description'] }}</p>
        @if(!empty($data['context']))
            <div class="text-[#333] text-sm leading-relaxed mt-4 max-w-xl mx-auto">{!! $data['context'] !!}</div>
        @endif
    </div>

@elseif($style === 'inline_left')
    <div class="flex items-center gap-8 py-4 lg:flex-col lg:items-start">
        <p class="text-5xl font-bold shrink-0" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <div>
            <p class="text-[#333] font-bold mb-1">{{ $data['description'] }}</p>
            @if(!empty($data['context']))
                <div class="text-[#6B7785] text-sm leading-relaxed">{!! $data['context'] !!}</div>
            @endif
        </div>
    </div>

@elseif($style === 'accent_border')
    <div class="border-l-4 pl-6 py-4" style="border-color: {{ $colorHex }}">
        <p class="text-4xl font-bold mb-2" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <p class="text-[#333] font-bold">{{ $data['description'] }}</p>
        @if(!empty($data['context']))
            <div class="text-[#6B7785] text-sm leading-relaxed mt-2">{!! $data['context'] !!}</div>
        @endif
    </div>
@endif
