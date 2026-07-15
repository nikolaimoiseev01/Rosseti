{{-- Timeline Block --}}
@php
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
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
<div class="{{ $spacingTop }} {{ $spacingBottom }}">
    @if(!empty($data['title']))
        <h3 class="text-2xl font-bold mb-8 leading-tight" style="color: {{ $colorHex }}">{{ $data['title'] }}</h3>
    @endif

    <div class="relative pl-[100px]">
        {{-- Vertical line --}}
        <div class="absolute left-[7px] top-2 bottom-2 w-[2px]" style="background-color: {{ $colorHex }}20"></div>

        @foreach($data['events'] ?? [] as $i => $event)
            <div class="relative mb-8 last:mb-0">
                {{-- Dot --}}
                <div class="absolute -left-[100px] top-1.5 w-4 h-4 rounded-full border-[3px] bg-white" style="border-color: {{ $colorHex }}"></div>

                <div class="flex flex-col gap-1">
                    <p class="text-lg font-bold leading-tight" style="color: {{ $colorHex }}">{{ $event['year'] }}</p>
                    <div>
                        <p class="font-bold text-[#1A1A1A] leading-tight whitespace-pre-line">{!! $event['title'] !!}</p>
                        @if(!empty($event['description']))
                            <p class="text-sm text-[#6B7785] mt-1 leading-relaxed whitespace-pre-line">{{ $event['description'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
