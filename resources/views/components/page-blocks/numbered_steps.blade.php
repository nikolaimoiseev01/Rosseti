{{-- Numbered Steps Block --}}
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

    <div class="space-y-6">
        @foreach($data['steps'] ?? [] as $i => $step)
            <div class="flex gap-5 items-start">
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-white font-bold text-lg" style="background-color: {{ $colorHex }}">
                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                </div>
                <div class="pt-1.5">
                    <p class="font-bold text-[#1A1A1A] text-lg">{{ $step['title'] }}</p>
                    @if(!empty($step['description']))
                        <p class="text-sm text-[#6B7785] mt-1 leading-relaxed">{{ $step['description'] }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
