{{-- Stats Grid Block --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
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

    $gridCols = match($data['columns'] ?? 'auto') {
        2 => 'grid-cols-2 lg:grid-cols-1',
        3 => 'grid-cols-3 lg:grid-cols-1',
        4 => 'grid-cols-4 lg:grid-cols-1',
        default => 'grid-cols-[repeat(auto-fit,minmax(200px,1fr))]',
    };
@endphp

<div id="{{ $blockId }}" class="    page-block
    page-block--stats-grid
    grid
    {{ $gridCols }}
    gap-5
    {{ $spacingTop }} {{ $spacingBottom }}">
    @foreach($data['items'] as $item)
        @php
            $valueText = $item['value'] ?? '0';
            preg_match('/^([><= ~]*)([\d.,]+)(.*)$/s', $valueText, $matches);
            $prefix = isset($matches[1]) ? $matches[1] : '';
            $numericValue = isset($matches[2]) ? (float) str_replace(',', '.', $matches[2]) : 0;
            $suffix = isset($matches[3]) ? $matches[3] : '';
        @endphp
        <div x-data="revealOnScroll()" x-init="animateCounter({{ $numericValue }}, '{{ $suffix }}', '{{ $prefix }}')" class="{{ $bgColor }} rounded-2xl p-6 border {{ $borderColor }} text-center">
            <div class="text-[80px] font-normal mb-1 {{colorHelper('main_color', $data)}}">
                <span class="{{colorHelper('main_color', $data)}}" x-text="displayValue"></span>
                @if(!empty($item['unit']))
                    <h3 class="font-light inline-block {{colorHelper('unit_color', $data)}}">{{ $item['unit'] }}</h3>
                @endif
            </div>
            <p class="mt-2 {{colorHelper('text_color', $data)}}">{{ $item['description'] }}</p>
        </div>
    @endforeach
</div>
