{{-- Person Card Block --}}
@php
    $colorHex = match($data['color'] ?? 'primary') {
        'accent' => '#2196F3',
        default => '#00355A',
    };
@endphp
<div class="max-w-3xl">
    @if(!empty($data['heading']))
        <h3 class="text-2xl font-bold leading-snug mb-6" style="color: {{ $colorHex }}">{{ $data['heading'] }}</h3>
    @endif

    <div class="text-[15px] leading-relaxed text-[#333] space-y-4 mb-8">
        {!! $data['text'] !!}
    </div>

    <div class="flex items-center gap-5">
        @if(!empty($data['photo']))
            <img
                src="{{ Storage::url($data['photo']) }}"
                alt="{{ $data['name'] }}"
                class="w-[100px] h-[100px] rounded-full object-cover shrink-0"
            >
        @endif
        <div>
            <p class="font-bold text-[#1A1A1A]">{{ $data['name'] }}</p>
            @if(!empty($data['position']))
                <p class="text-sm text-[#6B7785]">{{ $data['position'] }}</p>
            @endif
        </div>
    </div>
</div>
