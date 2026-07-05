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
        <x-g-r-i :textColor="$textColor" gri="{{$gri}}"/>
    @endif

    <p class="{{$textClass}}">{{ $text }}</p>
</div>
