{{-- Stats Grid Block --}}
@php
    $color = $data['color'] ?? 'primary';
    $colorHex = match($color) {
        'accent' => '#2196F3',
        default => '#00355A',
    };
    $textColor = match($data['text_color'] ?? 'auto') {
        'white' => '#FFFFFF',
        'dark' => '#1A1A1A',
        'auto' => null,
        default => null,
    };
    $descColor = match($data['text_color'] ?? 'auto') {
        'white' => 'rgba(255,255,255,0.7)',
        'dark' => '#6B7785',
        'auto' => null,
        default => null,
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

<div class="page-block page-block--stats-grid grid grid-cols-4 gap-5 md:grid-cols-2 sm:grid-cols-1 {{ $spacingTop }} {{ $spacingBottom }}">
    @foreach($data['items'] as $item)
        <div class="bg-[#F7F9FC] rounded-2xl p-6 border border-[#E1E7F0] text-center">
            <div class="text-4xl font-bold mb-1" style="color: {{ $colorHex }}">
                {{ $item['value'] }}
                @if(!empty($item['unit']))
                    <span class="text-xl font-normal" style="color: {{ $descColor ?? '#6B7785' }}">{{ $item['unit'] }}</span>
                @endif
            </div>
            <p class="text-sm leading-snug mt-2" style="color: {{ $descColor ?? '#6B7785' }}">{{ $item['description'] }}</p>
        </div>
    @endforeach
</div>
