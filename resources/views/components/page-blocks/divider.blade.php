{{-- Divider Block --}}
@php
    $style = $data['style'] ?? 'line';
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

@if($style === 'line')
    <hr class="page-block page-block--divider border-t border-[#E1E7F0] {{ $spacingTop }} {{ $spacingBottom }}">
@elseif($style === 'thick')
    <hr class="page-block page-block--divider border-t-2 border-[#00355A]/20 {{ $spacingTop }} {{ $spacingBottom }}">
@elseif($style === 'space')
    <div class="page-block page-block--divider {{ $spacingTop }} {{ $spacingBottom }}"></div>
@elseif($style === 'dots')
    <div class="page-block page-block--divider flex justify-center gap-2 {{ $spacingTop }} {{ $spacingBottom }}">
        <span class="w-1.5 h-1.5 rounded-full bg-[#C0CDDB]"></span>
        <span class="w-1.5 h-1.5 rounded-full bg-[#C0CDDB]"></span>
        <span class="w-1.5 h-1.5 rounded-full bg-[#C0CDDB]"></span>
    </div>
@endif
