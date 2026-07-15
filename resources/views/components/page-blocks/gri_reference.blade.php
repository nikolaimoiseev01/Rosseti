{{-- GRI Reference Block --}}
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

<div class="page-block page-block--gri-reference flex items-center gap-3 {{ $spacingTop }} {{ $spacingBottom }}">
    <span class="inline-block bg-[#2196F3] text-white font-bold text-sm px-3 py-1.5 rounded">GRI</span>
    <span class="text-[#6B7785] text-lg">{{ $data['codes'] }}</span>
</div>
