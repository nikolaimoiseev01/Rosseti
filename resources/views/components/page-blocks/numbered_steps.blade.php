{{-- Numbered Steps Block --}}
@php
    $colorHex = match($data['color'] ?? 'accent') {
        'primary' => '#00355A',
        default => '#2196F3',
    };
    $iconStyle = $data['icon_style'] ?? 'numbers';
    $connected = $data['connected'] ?? false;

    $styleClass = function($style) use ($colorHex) {
        return match($style) {
            'large_bold' => 'text-lg font-bold text-[#1A1A1A]',
            'normal' => 'text-base text-[#333]',
            'small' => 'text-sm text-[#333]',
            'accent' => 'text-base font-bold',
            'muted' => 'text-sm text-[#6B7785]',
            default => 'text-base text-[#333]',
        };
    };
@endphp

@if(!empty($data['title']))
    <p class="text-xl font-bold text-[#1A1A1A] mb-6">{{ $data['title'] }}</p>
@endif

<div class="space-y-0">
    @foreach($data['steps'] ?? [] as $index => $step)
        @php
            $isLast = $loop->last;
            $isTitleAccent = ($step['title_style'] ?? 'large_bold') === 'accent';
            $isDescAccent = ($step['desc_style'] ?? 'normal') === 'accent';
        @endphp
        <div class="flex items-center gap-5 {{ !$isLast ? 'mb-0' : '' }}">
            {{-- Circle + connecting line --}}
            <div class="relative flex flex-col items-center shrink-0" style="width: 44px;">
                @if($connected && !$isLast)
                    <div class="absolute top-[44px] w-[2px] h-full" style="background-color: {{ $colorHex }}20; left: 50%; transform: translateX(-50%);"></div>
                @endif
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0" style="background-color: {{ $colorHex }}">
                    @if($iconStyle === 'checkmarks')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    @elseif($iconStyle === 'dots')
                        <span class="w-3 h-3 rounded-full bg-white"></span>
                    @else
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <div class="{{ $connected && !$isLast ? 'pb-6' : 'pb-4' }}">
                <p class="{{ $styleClass($step['title_style'] ?? 'large_bold') }}"
                   @if($isTitleAccent) style="color: {{ $colorHex }}" @endif
                >{{ $step['title'] }}</p>
                @if(!empty($step['description']))
                    <p class="{{ $styleClass($step['desc_style'] ?? 'normal') }} mt-1"
                       @if($isDescAccent) style="color: {{ $colorHex }}" @endif
                    >{{ $step['description'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
