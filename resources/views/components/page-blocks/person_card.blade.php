{{-- Person Card Block --}}
@php
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
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

<style>
    .page-block--person-card img {
        margin: 0 !important;
    }
</style>
<div x-data="revealOnScroll()" class="bg-black-600 page-block p-6 rounded-lg page-block--person-card max-w-3xl {{ $spacingTop }} {{ $spacingBottom }}">
    @if(!empty($data['heading']))
        <h3 class="text-blue-500 text-2xl inline-block mb-6" style="color: {{ $colorHex }}">{{ $data['heading'] }}</h3>
    @endif

    <div class="text-[15px] leading-relaxed text-[#333] space-y-4 mb-8">
        {!! $data['text'] !!}
    </div>

    <div class="flex items-center gap-5">
        @if(!empty($data['photo']))
            <img
                src="{{ Storage::url($data['photo']) }}"
                alt="{{ $data['name'] }}"
                class="w-[100px] h-[100px] rounded-full object-cover shrink-0"
            >
        @endif
        <div>
            <p class="font-bold text-[#1A1A1A]">{{ $data['name'] }}</p>
            @if(!empty($data['position']))
                <p class="text-sm text-[#6B7785]">{{ $data['position'] }}</p>
            @endif
        </div>
    </div>
</div>
