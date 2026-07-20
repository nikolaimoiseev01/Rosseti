{{-- Quote Block --}}
@php
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
@endphp

<blockquote class="page-block page-block--quote relative bg-[#F7F9FC] rounded-2xl p-8 pr-14 border-l-4 border-[#00355A] {{ $spacingTop }} {{ $spacingBottom }}">
    <p class="text-lg text-[#333] leading-relaxed mb-4">{{ $data['text'] }}</p>
{{--    <svg class="absolute bottom-6 right-6 w-10 h-10 text-[#00355A]/15" fill="currentColor" viewBox="0 0 24 24">--}}
{{--        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>--}}
{{--    </svg>--}}
    @if(!empty($data['author']))
        <footer class="text-sm">
            <strong class="text-[#00355A]">{{ $data['author'] }}</strong>
            @if(!empty($data['position']))
                <span class="text-[#6B7785] ml-1">— {{ $data['position'] }}</span>
            @endif
        </footer>
    @endif
</blockquote>
