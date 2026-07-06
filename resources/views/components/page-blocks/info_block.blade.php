{{-- Info Block --}}
@php
    $style = $data['style'] ?? 'light';
    $textSize = match($data['text_size'] ?? 'normal') {
        'small' => 'text-sm',
        'large' => 'text-lg',
        default => 'text-[15px]',
    };
@endphp

@if($style === 'blue')
    {{-- Blue bg: force white text via inline style to override global * rule --}}
    <div class="rounded-2xl bg-blue-600 p-8" style="color: #fff;">
        <div class="{{ $textSize }} leading-relaxed" style="color: #fff;">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'light')
    <div class="rounded-2xl bg-[#F0F5FA] p-8">
        <div class="{{ $textSize }} leading-relaxed text-black-500">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'accent')
    <div class="border-l-4 border-blue-400 bg-[#F7F9FC] rounded-2xl p-8">
        <div class="{{ $textSize }} leading-relaxed text-black-500">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'dark')
    {{-- Dark bg: force white text via inline style to override global * rule --}}
    <div class="rounded-2xl bg-blue-700 p-8" style="color: #fff;">
        <div class="{{ $textSize }} leading-relaxed" style="color: #fff;">{!! $data['content'] !!}</div>
    </div>
@endif
