{{-- Info Block --}}
@php
    $style = $data['style'] ?? 'light';
    $textColor = $data['text_color'] ?? 'auto';
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

    $pColor = match($textColor) {
        'white' => '#ffffff',
        'dark' => '#1A1A1A',
        'auto' => match($style) {
            'blue' => '#ffffff',
            'light' => '#333333',
            'accent' => '#333333',
            'dark' => '#ffffff',
            'bordered' => '#00355A',
            default => '#333333',
        },
        default => match($style) {
            'blue' => '#ffffff',
            'light' => '#333333',
            'accent' => '#333333',
            'dark' => '#ffffff',
            'bordered' => '#00355A',
            default => '#333333',
        },
    };
@endphp

<style>
    .page-block--info-block p {
        color: {{ $pColor }};
    }
</style>

@if($style === 'blue')
    <div class="page-block page-block--info-block rounded-2xl bg-blue-400 p-6 {{ $spacingTop }} {{ $spacingBottom }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'light')
    <div class="page-block page-block--info-block rounded-2xl bg-[#F0F5FA] p-6 {{ $spacingTop }} {{ $spacingBottom }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'accent')
    <div class="page-block page-block--info-block border-l-4 border-[#2196F3] bg-[#F7F9FC] rounded-2xl p-6 {{ $spacingTop }} {{ $spacingBottom }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'dark')
    <div class="page-block page-block--info-block rounded-2xl bg-[#1B2733] p-6 {{ $spacingTop }} {{ $spacingBottom }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'bordered')
    <div class="page-block page-block--info-block rounded-2xl bg-white border border-gray-200 p-6 {{ $spacingTop }} {{ $spacingBottom }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>
@endif
