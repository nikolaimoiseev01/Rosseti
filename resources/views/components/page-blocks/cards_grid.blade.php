{{-- Cards Grid Block --}}
@php
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
    $cols = match($data['columns'] ?? '3') {
        '2' => 'grid-cols-2 sm:grid-cols-1',
        '4' => 'grid-cols-4 lg:grid-cols-2 sm:grid-cols-1',
        default => 'grid-cols-3 lg:grid-cols-2 sm:grid-cols-1',
    };
    $titleSize = match($data['title_size'] ?? 'normal') {
        'small' => 'text-sm',
        'large' => 'text-lg',
        default => 'text-base',
    };
    $logoSize = match($data['logo_size'] ?? 'normal') {
        'small' => 'w-12 h-12',
        'large' => 'w-20 h-20',
        'xlarge' => 'w-24 h-24',
        default => 'w-16 h-16',
    };
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
<div class="page-block page-block--cards-grid grid {{ $cols }} gap-5 {{ $spacingTop }} {{ $spacingBottom }}">
    @foreach($data['cards'] ?? [] as $card)
        <div class="bg-[#F7F9FC] rounded-2xl p-6 border border-[#E1E7F0]/60 hover:border-[#2196F3]/30 transition-colors">
            @if(!empty($card['icon']))
                <img src="{{ Storage::url($card['icon']) }}" alt="" class="{{ $logoSize }} object-contain mb-4">
            @endif
            <h4 class="font-bold {{ $titleSize }} mb-2" style="color: {{ $colorHex }}">{{ $card['title'] }}</h4>
            @if(!empty($card['text']))
                <p class="text-sm text-[#6B7785] leading-relaxed">{{ $card['text'] }}</p>
            @endif
        </div>
    @endforeach
</div>
