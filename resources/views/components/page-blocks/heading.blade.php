{{-- Heading Block --}}
@php
    $level = $data['level'] ?? 'h2';

    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '',
        'small' => 'mt-2',
        'normal' => 'mt-4', 'medium' => 'mt-6',
        'large' => 'mt-8',
        'xl' => 'mt-12',
        '2xl' => 'mt-16',
        '3xl' => 'mt-24',
        default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '',
        'small' => 'mb-2',
        'normal' => 'mb-4', 'medium' => 'mb-6',
        'large' => 'mb-8',
        'xl' => 'mb-12',
        '2xl' => 'mb-16',
        '3xl' => 'mb-24',
        default => 'mb-12',
    };

@endphp
<{{ $level }} x-data="revealOnScroll()" class="page-block page-block--heading {{colorHelper('color', $data)}} {{ "!" . $spacingTop }} {{ "!" . $spacingBottom }}">
    @if(isset($data['tooltip']))
        <span class="has-tooltip
        {{colorHelper('color', $data)}}
        {{colorHelper('font_weight', $data)}}
        " data-tooltip="{{ $data['tooltip'] }}" aria-label="{{ $data['tooltip'] }}" data-alpine-devtools-right-click="">{!! $data['content'] !!}</span>
    @else
        {!! $data['content'] !!}
    @endif
</{{ $level }}>
