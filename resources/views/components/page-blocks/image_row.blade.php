{{-- Image Row Block (multiple images/icons in a horizontal row) --}}
@php
    $sizeClass = match($data['size'] ?? 'small') {
        'small' => 'h-[60px]',
        'medium' => 'h-[120px]',
        'large' => 'h-[200px]',
        default => 'h-[60px]',
    };
    $gapClass = match($data['gap'] ?? 'normal') {
        'tight' => 'gap-1',
        'normal' => 'gap-3',
        'wide' => 'gap-6',
        default => 'gap-3',
    };
@endphp
<div class="flex flex-wrap items-center {{ $gapClass }}">
    @foreach($data['images'] ?? [] as $image)
        @if(!empty($image['url']))
            <img
                src="{{ Storage::url($image['url']) }}"
                alt="{{ $image['alt'] ?? '' }}"
                class="{{ $sizeClass }} w-auto object-contain"
                loading="lazy"
            >
        @endif
    @endforeach
</div>
