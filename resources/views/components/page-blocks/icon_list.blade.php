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

<style>
    .page-block--icon-list img {
        margin: 0 !important;
    }
</style>
<div class="page-block page-block--icon-list space-y-4 {{ $spacingTop }} {{ $spacingBottom }}">
    @foreach($data['items'] ?? [] as $item)
        @php
            $isTitleAccent = ($item['title_style'] ?? 'large_bold') === 'accent';
        @endphp
        <div class="flex items-start gap-4">
            @if(!empty($item['icon']))
                <img src="{{ Storage::url($item['icon']) }}" alt="" class="{{ $iconSize }} object-contain shrink-0">
            @endif
            <div>
                <h3 class="{{colorHelper('title_color', $data)}}" @if($isTitleAccent) style="color: {{ $colorHex }}" @endif>{{ $item['title'] }}</h3>
                @if(!empty($item['text']))
                    <p class="{{colorHelper('desc_color', $data)}} mt-1">{{ $item['text'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
