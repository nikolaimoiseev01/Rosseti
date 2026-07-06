{{-- Image Row Block --}}
@php
    $size = match($data['size'] ?? 'small') {
        'medium' => 'h-[120px]',
        'large' => 'h-[200px]',
        'xlarge' => 'h-[300px]',
        'xxlarge' => 'h-[400px]',
        'full' => 'h-[500px]',
        default => 'h-[60px]',
    };
    $gap = match($data['gap'] ?? 'normal') {
        'tight' => 'gap-1',
        'wide' => 'gap-6',
        default => 'gap-3',
    };
@endphp

<div class="flex flex-wrap items-center {{ $gap }}">
    @foreach($data['images'] ?? [] as $img)
        <img src="{{ Storage::url($img['url']) }}" alt="{{ $img['alt'] ?? '' }}" class="{{ $size }} object-contain">
    @endforeach
</div>
