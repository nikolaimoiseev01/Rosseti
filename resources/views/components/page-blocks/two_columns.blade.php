{{-- Two Columns Text Block --}}
@php
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

<div class="page-block page-block--two-columns grid grid-cols-2 gap-8 md:grid-cols-1 {{ $spacingTop }} {{ $spacingBottom }}">
    <div class="prose prose-lg max-w-none text-[#333] prose-p:leading-relaxed prose-a:text-[#005B9C]">
        {!! $data['left'] !!}
    </div>
    <div class="prose prose-lg max-w-none text-[#333] prose-p:leading-relaxed prose-a:text-[#005B9C]">
        {!! $data['right'] !!}
    </div>
</div>
