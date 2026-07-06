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
            'large_bold' => 'text-lg font-bold',
            'normal' => 'text-base',
            'small' => 'text-sm',
            'accent' => 'text-base font-bold',
            'muted' => 'text-sm',
            default => 'text-base',
        };
    };
    $styleColor = function($style) use ($colorHex) {
        return match($style) {
            'large_bold' => '#1A1A1A',
            'accent' => $colorHex,
            'muted' => '#6B7785',
            default => '#333',
        };
    };
@endphp

@if(!empty($data['title']))
    <p class="text-xl font-bold mb-6" style="color: #1A1A1A;">{{ $data['title'] }}</p>
@endif

<div>
    @foreach($data['steps'] ?? [] as $index => $step)
        @php $isLast = $loop->last; @endphp

        {{-- Separator line between steps --}}
        @if(!$loop->first)
            <div style="border-top: 1px solid #E1E7F0; margin: 0;"></div>
        @endif

        <div style="display: flex; align-items: flex-start; gap: 20px; padding: 20px 0;">
            {{-- Circle --}}
            <div style="width: 44px; min-width: 44px; height: 44px; min-height: 44px; border-radius: 50%; background-color: {{ $colorHex }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                @if($iconStyle === 'checkmarks')
                    <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                @elseif($iconStyle === 'dots')
                    <span style="width: 12px; height: 12px; border-radius: 50%; background: white; display: block;"></span>
                @else
                    <span style="color: white; font-weight: bold; font-size: 14px;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                @endif
            </div>

            {{-- Content --}}
            <div style="padding-top: 4px;">
                <p class="{{ $styleClass($step['title_style'] ?? 'large_bold') }}" style="color: {{ $styleColor($step['title_style'] ?? 'large_bold') }}; margin: 0;">{{ $step['title'] }}</p>
                @if(!empty($step['description']))
                    <p class="{{ $styleClass($step['desc_style'] ?? 'normal') }}" style="color: {{ $styleColor($step['desc_style'] ?? 'normal') }}; margin: 4px 0 0 0;">{{ $step['description'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
