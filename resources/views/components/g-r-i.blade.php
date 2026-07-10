@props(['gri',    'textColor' => null,])

@php
    $textClass = $textColor === 'white'
        ? 'text-white'
        : 'text-inherit';
@endphp

<div x-data="revealOnScroll()" {{ $attributes->merge(['class' => 'flex mb-4']) }}>
    <div class="bg-blue-400 mr-2 px-2 flex items-center">
        <span class="text-white">GRI</span>
    </div>
    <span  class="text-lg {{$textClass}}">{{ $gri }}</span>
</div>
