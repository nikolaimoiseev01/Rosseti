{{-- Timeline Block --}}
@php
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
@endphp
<div>
    @if(!empty($data['title']))
        <h3 class="text-2xl font-bold mb-8" style="color: {{ $colorHex }}">{{ $data['title'] }}</h3>
    @endif

    <div class="relative pl-8">
        {{-- Vertical line --}}
        <div class="absolute left-[7px] top-2 bottom-2 w-[2px]" style="background-color: {{ $colorHex }}20"></div>

        @foreach($data['events'] ?? [] as $i => $event)
            <div class="relative mb-8 last:mb-0">
                {{-- Dot --}}
                <div class="absolute -left-8 top-1.5 w-4 h-4 rounded-full border-[3px] bg-white" style="border-color: {{ $colorHex }}"></div>

                <div class="flex items-baseline gap-4">
                    <span class="text-lg font-bold min-w-[80px]" style="color: {{ $colorHex }}">{{ $event['year'] }}</span>
                    <div>
                        <p class="font-bold text-[#1A1A1A]">{{ $event['title'] }}</p>
                        @if(!empty($event['description']))
                            <p class="text-sm text-[#6B7785] mt-1 leading-relaxed">{{ $event['description'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
