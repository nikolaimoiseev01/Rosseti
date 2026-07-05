@props(['gri',    'textColor' => null,])

@php
    $textClass = $textColor === 'white'
        ? 'text-white'
        : 'text-inherit';
@endphp

<div class="flex mb-4">
    <span class="bg-blue-400 text-white mr-2 px-2">GRI</span>
    <span class="{{$textClass}}">{{ $gri }}</span>
</div>
