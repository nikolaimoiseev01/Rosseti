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
@endphp
<div class="grid {{ $cols }} gap-5">
    @foreach($data['cards'] ?? [] as $card)
        <div class="bg-[#F7F9FC] rounded-2xl p-6 border border-[#E1E7F0]/60 hover:border-[#2196F3]/30 transition-colors">
            @if(!empty($card['icon']))
                <img src="{{ Storage::url($card['icon']) }}" alt="" class="w-16 h-16 object-contain mb-4">
            @endif
            <h4 class="font-bold text-base mb-2" style="color: {{ $colorHex }}">{{ $card['title'] }}</h4>
            @if(!empty($card['text']))
                <p class="text-sm text-[#6B7785] leading-relaxed">{{ $card['text'] }}</p>
            @endif
        </div>
    @endforeach
</div>
