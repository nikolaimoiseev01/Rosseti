{{-- Key Figure Block --}}
@php
    $style = $data['style'] ?? 'card_blue';
    $color = $data['color'] ?? 'primary';
    $colorHex = match($color) {
        'accent' => '#2196F3',
        default => '#00355A',
    };
    $textColor = match($data['text_color'] ?? 'auto') {
        'white' => '#FFFFFF',
        'dark' => '#1A1A1A',
        'auto' => null,
        default => null,
    };
    $descColor = match($data['text_color'] ?? 'auto') {
        'white' => 'rgba(255,255,255,0.7)',
        'dark' => '#6B7785',
        'auto' => null,
        default => null,
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

@if($style === 'card_blue')
    @php
        $bgColor = $colorHex;
        $finalTextColor = $textColor ?? '#FFFFFF';
        $finalDescColor = $descColor ?? 'rgba(255,255,255,0.7)';
    @endphp
    <div class="page-block page-block--key-figure rounded-2xl p-8 flex flex-col justify-between items-stretch {{ $spacingTop }} {{ $spacingBottom }}" style="background-color: {{ $bgColor }}">
        @if(trim(strip_tags($data['context'])) !== '')
            <div class="text-sm leading-relaxed mb-4" style="color: {{ $finalTextColor }}">{!! $data['context'] !!}</div>
        @endif
        <div class="flex flex-col justify-center">
            <p class="text-5xl font-bold mb-2" style="color: {{ $finalTextColor }}">{{ $data['value'] }}</p>
            <p class="text-sm" style="color: {{ $finalDescColor }}">{{ $data['description'] }}</p>
        </div>
    </div>

@elseif($style === 'card_light')
    @php
        $finalTextColor = $textColor ?? '#1A1A1A';
        $finalDescColor = $descColor ?? '#6B7785';
    @endphp
    <div class="page-block page-block--key-figure rounded-2xl bg-[#F7F9FC] border border-[#E1E7F0] p-8 flex flex-col justify-between items-stretch {{ $spacingTop }} {{ $spacingBottom }}">
        @if(trim(strip_tags($data['context'] ?? '')) !== '')
            <div class="text-sm leading-relaxed mb-4" style="color: {{ $finalTextColor }}">{!! $data['context'] ?? '' !!}</div>
        @endif
        <div class="flex flex-col justify-center">
            <p class="text-5xl font-bold mb-2" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
            <p class="text-sm" style="color: {{ $finalDescColor }}">{{ $data['description'] }}</p>
        </div>
    </div>

@elseif($style === 'inline_large')
    @php
        $finalTextColor = $textColor ?? '#1A1A1A';
        $finalDescColor = $descColor ?? '#6B7785';
    @endphp
    <div class="page-block page-block--key-figure text-center py-8 flex flex-col items-center justify-center {{ $spacingTop }} {{ $spacingBottom }}">
        <p class="text-6xl font-bold mb-3" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <p class="text-lg" style="color: {{ $finalDescColor }}">{{ $data['description'] }}</p>
        @if(trim(strip_tags($data['context'] ?? '')) !== '')
            <div class="text-sm leading-relaxed mt-4 max-w-xl mx-auto" style="color: {{ $finalTextColor }}">{!! $data['context'] ?? '' !!}</div>
        @endif
    </div>

@elseif($style === 'inline_left')
    @php
        $finalTextColor = $textColor ?? '#1A1A1A';
        $finalDescColor = $descColor ?? '#6B7785';
    @endphp
    <div class="page-block page-block--key-figure flex items-center gap-8 py-4 lg:flex-col lg:items-start min-h-[80px] {{ $spacingTop }} {{ $spacingBottom }}">
        <p class="text-5xl font-bold shrink-0" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <div>
            <p class="font-bold mb-1" style="color: {{ $finalTextColor }}">{{ $data['description'] }}</p>
            @if(!empty($data['context'] ?? ''))
                <div class="text-sm leading-relaxed" style="color: {{ $finalDescColor }}">{!! $data['context'] ?? '' !!}</div>
            @endif
        </div>
    </div>

@elseif($style === 'accent_border')
    @php
        $finalTextColor = $textColor ?? '#1A1A1A';
        $finalDescColor = $descColor ?? '#6B7785';
    @endphp
    <div class="page-block page-block--key-figure border-l-4 pl-6 py-4 flex flex-col justify-center {{ $spacingTop }} {{ $spacingBottom }}" style="border-color: {{ $colorHex }}">
        <p class="text-4xl font-bold mb-2" style="color: {{ $colorHex }}">{{ $data['value'] }}</p>
        <p class="font-bold" style="color: {{ $finalTextColor }}">{{ $data['description'] }}</p>
        @if(trim(strip_tags($data['context'] ?? '')) !== '')
            <div class="text-sm leading-relaxed mt-2" style="color: {{ $finalDescColor }}">{!! $data['context'] ?? '' !!}</div>
        @endif
    </div>
@endif
