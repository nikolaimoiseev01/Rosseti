@props([
    'title',
    'text',
    'gri' => null,
    'textColor' => null,
])

@php
    $titleClass = $textColor === 'white'
        ? 'text-white'
        : 'text-blue-500';
    $textClass = $textColor === 'white'
        ? 'text-white'
        : 'text-ingerit';
@endphp

<div x-data="revealOnScroll()" {{ $attributes->merge(['class' => "flex flex-col {$textClass}"]) }}>
    <h3 class="text-2xl mb-2 {{$titleClass}}">{{ $title }}</h3>

    @if($gri)
        <x-g-r-i :textColor="$textColor" gri="{{$gri}}"/>
    @endif

    <p class="{{$textClass}}">{{ $text }}</p>
</div>
