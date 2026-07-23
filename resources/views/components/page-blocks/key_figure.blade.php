{{-- Key Figure Block --}}
@php
    $style = $data['style'] ?? 'card_blue';
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
    <div x-data="revealOnScroll()" class="page-block page-block--key-figure rounded-2xl p-8 flex flex-col justify-between items-stretch {{ $spacingTop }} {{ $spacingBottom }} {{colorHelper('bg_color', $data)}}">
        @if(trim(strip_tags($data['context'])) !== '')
            <div class="text-sm leading-relaxed mb-4 {{colorHelper('context_color', $data)}}">{!! $data['context'] !!}</div>
        @endif
        <div class="flex flex-col justify-center">
            <p class="text-[80px] leading-[80px] font-normal mb-2 {{colorHelper('main_color', $data)}}">{{ $data['value'] }}</p>
            <h3 class="mb-0 {{colorHelper('text_color', $data)}}">{{ $data['description'] }}</h3>
        </div>
    </div>

@elseif($style === 'card_light')
    <div x-data="revealOnScroll()" class="page-block page-block--key-figure rounded-2xl bg-[#F7F9FC] border border-[#E1E7F0] p-8 flex flex-col justify-between items-stretch {{ $spacingTop }} {{ $spacingBottom }}">
        @if(trim(strip_tags($data['context'] ?? '')) !== '')
            <div class="text-sm leading-relaxed mb-4 {{colorHelper('context_color', $data)}}">{!! $data['context'] ?? '' !!}</div>
        @endif
        <div class="flex flex-col justify-center">
            <p class="text-[80px] leading-[80px] font-normal mb-2 {{colorHelper('main_color', $data)}}">{{ $data['value'] }}</p>
            <h3 class="mb-0 {{colorHelper('text_color', $data)}}">{{ $data['description'] }}</h3>
        </div>
    </div>

@elseif($style === 'inline_large')
    <div x-data="revealOnScroll()" class="page-block page-block--key-figure text-center py-8 flex flex-col items-center justify-center {{ $spacingTop }} {{ $spacingBottom }}">
        <p class="text-[80px] leading-[80px] font-normal mb-3 {{colorHelper('main_color', $data)}}">{{ $data['value'] }}</p>
        <h3 class="mb-0 {{colorHelper('text_color', $data)}}">{{ $data['description'] }}</h3>
        @if(trim(strip_tags($data['context'] ?? '')) !== '')
            <div class="text-sm leading-relaxed mt-4 max-w-xl mx-auto {{colorHelper('context_color', $data)}}">{!! $data['context'] ?? '' }}</div>
        @endif
    </div>

@elseif($style === 'inline_left')
    <div x-data="revealOnScroll()" class="page-block page-block--key-figure flex items-center gap-8 py-4 lg:flex-col lg:items-start min-h-[80px] {{ $spacingTop }} {{ $spacingBottom }}">
        <p class="text-[80px] leading-[80px] font-normal shrink-0 {{colorHelper('main_color', $data)}}">{{ $data['value'] }}</p>
        <div>
            <p class="font-bold mb-1 {{colorHelper('text_color', $data)}}">{{ $data['description'] }}</p>
            @if(!empty($data['context'] ?? ''))
                <div class="text-sm leading-relaxed {{colorHelper('context_color', $data)}}">{!! $data['context'] ?? '' !!}</div>
            @endif
        </div>
    </div>

@elseif($style === 'accent_border')
    <div x-data="revealOnScroll()" class="page-block page-block--key-figure border-l-4 pl-6 py-4 flex flex-col justify-center {{ $spacingTop }} {{ $spacingBottom }} {{colorHelper('main_color', $data)}}" style="border-color: currentColor">
        <p class="text-[80px] leading-[80px] font-normal mb-2 {{colorHelper('main_color', $data)}}">{{ $data['value'] }}</p>
        <h3 class="mb-0 {{colorHelper('text_color', $data)}}">{{ $data['description'] }}</h3>
        @if(trim(strip_tags($data['context'] ?? '')) !== '')
            <div class="text-sm leading-relaxed mt-2 {{colorHelper('context_color', $data)}}">{!! $data['context'] ?? '' }}</div>
        @endif
    </div>
@endif
