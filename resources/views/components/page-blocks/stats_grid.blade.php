{{-- Stats Grid Block --}}
@php
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

<div class="grid grid-cols-4 gap-5 md:grid-cols-2 sm:grid-cols-1 {{ $spacingTop }} {{ $spacingBottom }}">
    @foreach($data['items'] as $item)
        <div class="bg-[#F7F9FC] rounded-2xl p-6 border border-[#E1E7F0] text-center">
            <div class="text-4xl font-bold text-[#005B9C] mb-1">
                {{ $item['value'] }}
                @if(!empty($item['unit']))
                    <span class="text-xl font-normal text-[#6B7785]">{{ $item['unit'] }}</span>
                @endif
            </div>
            <p class="text-sm text-[#6B7785] leading-snug mt-2">{{ $item['description'] }}</p>
        </div>
    @endforeach
</div>
