{{-- Stats Grid Block --}}
@php
    $bgColor = match($data['background_color'] ?? 'transparent') {
        'transparent' => 'bg-transparent',
        'white' => 'bg-white',
        'gray-50' => 'bg-gray-50',
        'gray-100' => 'bg-gray-100',
        'gray-200' => 'bg-gray-200',
        'blue-50' => 'bg-blue-50',
        'blue-100' => 'bg-blue-100',
        'blue-900' => 'bg-blue-900',
        default => 'bg-[#F7F9FC]',
    };
    $borderColor = match($data['background_color'] ?? 'transparent') {
        'transparent' => 'border-transparent',
        'white' => 'border-gray-200',
        'gray-50' => 'border-gray-200',
        'gray-100' => 'border-gray-300',
        'gray-200' => 'border-gray-400',
        'blue-50' => 'border-blue-200',
        'blue-100' => 'border-blue-300',
        'blue-900' => 'border-blue-800',
        default => 'border-[#E1E7F0]',
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

<div x-data="revealOnScroll()" class="page-block page-block--stats-grid grid grid-cols-4 gap-5 md:grid-cols-2 sm:grid-cols-1 {{ $spacingTop }} {{ $spacingBottom }}">
    @foreach($data['items'] as $item)
        <div class="{{ $bgColor }} rounded-2xl p-6 border {{ $borderColor }} text-center">
            <div class="text-[80px] font-normal mb-1 {{colorHelper('main_color', $data)}}">
                {{ $item['value'] }}
                @if(!empty($item['unit']))
                    <h3 class="font-light inline-block {{colorHelper('unit_color', $data)}}">{{ $item['unit'] }}</h3>
                @endif
            </div>
            <p class="mt-2 {{colorHelper('text_color', $data)}}">{{ $item['description'] }}</p>
        </div>
    @endforeach
</div>
