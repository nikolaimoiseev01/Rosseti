{{-- Image Row Block --}}
@php
    $size = match($data['size'] ?? 'small') {
        'medium' => 'h-[120px]',
        'large' => 'h-[200px]',
        'xlarge' => 'h-[300px]',
        'xxlarge' => 'h-[400px]',
        'full' => 'h-[500px]',
        'ultra' => 'h-[600px]',
        'mega' => 'h-[800px]',
        default => 'h-[60px]',
    };
    $gap = match($data['gap'] ?? 'normal') {
        'tight' => 'gap-1',
        'wide' => 'gap-6',
        default => 'gap-3',
    };
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

<div class="page-block page-block--image-row flex flex-wrap items-center {{ $gap }} {{ $spacingTop }} {{ $spacingBottom }}">
    @foreach($data['images'] ?? [] as $img)
        <img src="{{ Storage::url($img['url']) }}" alt="{{ $img['alt'] ?? '' }}" class="{{ $size }} object-contain">
    @endforeach
</div>
