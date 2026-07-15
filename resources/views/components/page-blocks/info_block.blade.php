{{-- Info Block --}}
@php
    $style = $data['style'] ?? 'light';
    $textColor = $data['text_color'] ?? 'auto';
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

    $textColorClass = match($textColor) {
        'white' => 'text-white [&_*]:text-white [&_p]:text-white [&_strong]:text-white [&_a]:text-white',
        'dark' => 'text-[#1A1A1A] [&_*]:text-[#1A1A1A] [&_p]:text-[#1A1A1A] [&_strong]:text-[#1A1A1A] [&_a]:text-[#2196F3]',
        'auto' => null,
        default => null,
    };
@endphp

@if($style === 'blue')
    <div class="rounded-2xl bg-[#00355A] p-8 {{ $spacingTop }} {{ $spacingBottom }} {{ $textColorClass ?? 'text-white [&_*]:text-white [&_p]:text-white [&_strong]:text-white [&_a]:text-white' }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'light')
    <div class="rounded-2xl bg-[#F0F5FA] p-8 {{ $spacingTop }} {{ $spacingBottom }} {{ $textColorClass ?? 'text-[#333]' }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'accent')
    <div class="border-l-4 border-[#2196F3] bg-[#F7F9FC] rounded-2xl p-8 {{ $spacingTop }} {{ $spacingBottom }} {{ $textColorClass ?? 'text-[#333]' }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'dark')
    <div class="rounded-2xl bg-[#1B2733] p-8 {{ $spacingTop }} {{ $spacingBottom }} {{ $textColorClass ?? 'text-white [&_*]:text-white [&_p]:text-white [&_strong]:text-white [&_a]:text-white' }}">
        <div class="text-[15px] leading-relaxed">{!! $data['content'] !!}</div>
    </div>
@endif
