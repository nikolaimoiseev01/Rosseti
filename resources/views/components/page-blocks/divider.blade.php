{{-- Divider Block --}}
@php
    $style = $data['style'] ?? 'line';
@endphp

@if($style === 'line')
    <hr class="border-t border-[#E1E7F0] my-2">
@elseif($style === 'thick')
    <hr class="border-t-2 border-[#00355A]/20 my-2">
@elseif($style === 'space')
    <div class="h-10"></div>
@elseif($style === 'dots')
    <div class="flex justify-center gap-2 my-2">
        <span class="w-1.5 h-1.5 rounded-full bg-[#C0CDDB]"></span>
        <span class="w-1.5 h-1.5 rounded-full bg-[#C0CDDB]"></span>
        <span class="w-1.5 h-1.5 rounded-full bg-[#C0CDDB]"></span>
    </div>
@endif
