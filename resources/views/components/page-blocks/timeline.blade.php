{{-- Timeline Block --}}
@php
    $colorClass = match($data['color'] ?? 'primary') {
        'accent' => 'text-blue-400 border-blue-400',
        default => 'text-blue-600 border-blue-600',
    };
    $dotBorder = match($data['color'] ?? 'primary') {
        'accent' => 'border-blue-400',
        default => 'border-blue-600',
    };
    $lineBg = match($data['color'] ?? 'primary') {
        'accent' => 'bg-blue-400/20',
        default => 'bg-blue-600/20',
    };
    $titleColor = match($data['color'] ?? 'primary') {
        'accent' => 'text-blue-400',
        default => 'text-blue-600',
    };
@endphp
<div>
    @if(!empty($data['title']))
        <h3 class="text-2xl font-bold mb-8 {{ $titleColor }}">{{ $data['title'] }}</h3>
    @endif

    <div class="relative pl-8">
        {{-- Vertical line --}}
        <div class="absolute left-[7px] top-2 bottom-2 w-[2px] {{ $lineBg }}"></div>

        @foreach($data['events'] ?? [] as $i => $event)
            <div class="relative mb-8 last:mb-0">
                {{-- Dot --}}
                <div class="absolute -left-8 top-1.5 w-4 h-4 rounded-full border-[3px] bg-white {{ $dotBorder }}"></div>

                <div class="flex gap-4 items-baseline">
                    <span class="text-lg font-bold {{ $titleColor }} shrink-0 min-w-[100px]">{{ $event['year'] }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-black-500">{{ $event['title'] }}</p>
                        @if(!empty($event['description']))
                            <p class="text-sm text-black-400 mt-1 leading-relaxed">{{ $event['description'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
