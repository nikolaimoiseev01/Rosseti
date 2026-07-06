{{-- Icon List Block --}}
@php
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
    $iconSize = match($data['icon_size'] ?? 'medium') {
        'small' => 'w-6 h-6',
        'large' => 'w-[60px] h-[60px]',
        default => 'w-10 h-10',
    };

    $styleClass = function($style) {
        return match($style) {
            'large_bold' => 'text-base font-bold text-[#1A1A1A]',
            'normal' => 'text-sm text-[#333]',
            'small' => 'text-xs text-[#333]',
            'accent' => 'text-base font-bold',
            'muted' => 'text-sm text-[#6B7785]',
            default => 'text-base font-bold text-[#1A1A1A]',
        };
    };
@endphp

<div class="space-y-4">
    @foreach($data['items'] ?? [] as $item)
        @php
            $isTitleAccent = ($item['title_style'] ?? 'large_bold') === 'accent';
        @endphp
        <div class="flex items-start gap-4">
            @if(!empty($item['icon']))
                <img src="{{ Storage::url($item['icon']) }}" alt="" class="{{ $iconSize }} object-contain shrink-0">
            @endif
            <div>
                <p class="{{ $styleClass($item['title_style'] ?? 'large_bold') }}"
                   @if($isTitleAccent) style="color: {{ $colorHex }}" @endif
                >{{ $item['title'] }}</p>
                @if(!empty($item['text']))
                    <p class="text-sm text-[#6B7785] mt-1">{{ $item['text'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
