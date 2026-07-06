{{-- Rich Text Block with color and spacing --}}
@php
    $textColor = match($data['text_color'] ?? 'default') {
        'primary' => 'text-[#00355A]',
        'accent' => 'text-[#2196F3]',
        'muted' => 'text-[#6B7785]',
        'white' => 'text-white',
        default => 'text-[#1A1A1A]',
    };
    $spacing = match($data['spacing'] ?? 'normal') {
        'none' => 'mb-0',
        'small' => 'mb-2',
        'large' => 'mb-8',
        'xl' => 'mb-12',
        default => 'mb-4',
    };
@endphp

<div class="prose max-w-none {{ $textColor }} {{ $spacing }} [&_a]:text-[#2196F3] [&_a]:font-normal [&_a]:underline">
    {!! $data['content'] !!}
</div>
