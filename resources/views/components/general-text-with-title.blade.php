@props([
    'title',
    'text',
    'gri' => null,
    'textColor' => null,
])

@php
    $textClass = $textColor === 'white'
        ? 'text-white'
        : 'text-inherit';
@endphp

<div {{ $attributes->merge(['class' => "flex flex-col {$textClass}"]) }}>
    <h3 class="text-2xl mb-2 {{$textClass}}">{{ $title }}</h3>

    @if($gri)
        <div class="flex mb-4">
            <span class="bg-blue-400 text-white">GRI</span>
            <span>{{ $gri }}</span>
        </div>
    @endif

    <p class="{{$textClass}}">{{ $text }}</p>
</div>
