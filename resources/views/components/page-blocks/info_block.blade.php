{{-- Info Block --}}
@php
    $style = $data['style'] ?? 'light';
@endphp

@if($style === 'blue')
    <div class="rounded-2xl bg-[#00355A] p-8 text-white">
        <div class="text-[15px] leading-relaxed [&_*]:text-white">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'light')
    <div class="rounded-2xl bg-[#F0F5FA] p-8">
        <div class="text-[15px] leading-relaxed text-[#333]">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'accent')
    <div class="border-l-4 border-[#2196F3] bg-[#F7F9FC] rounded-r-2xl pl-6 pr-8 py-6">
        <div class="text-[15px] leading-relaxed text-[#333]">{!! $data['content'] !!}</div>
    </div>

@elseif($style === 'dark')
    <div class="rounded-2xl bg-[#1B2733] p-8 text-white">
        <div class="text-[15px] leading-relaxed [&_*]:text-white">{!! $data['content'] !!}</div>
    </div>
@endif
