{{-- Image Block --}}
@php
    $sizeClass = match($data['size'] ?? 'full') {
        'large' => 'max-w-[75%]',
        'medium' => 'max-w-[50%]',
        default => 'w-full',
    };
    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '',
        'small' => 'mt-2',
        'normal' => 'mt-4',
        'large' => 'mt-8',
        'xl' => 'mt-12',
        '2xl' => 'mt-16',
        '3xl' => 'mt-24',
        default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '',
        'small' => 'mb-2',
        'normal' => 'mb-4',
        'large' => 'mb-8',
        'xl' => 'mb-12',
        '2xl' => 'mb-16',
        '3xl' => 'mb-24',
        default => 'mb-12',
    };
@endphp
<figure class="page-block page-block--image {{ $sizeClass }} {{ $spacingTop }} {{ $spacingBottom }}">
    @if($data['url'])
        <img
            src="{{ Storage::url($data['url']) }}"
            alt="{{ $data['caption'] ?? '' }}"
            class="w-full rounded-2xl shadow-md"
            loading="lazy"
        >
    @else
{{--        <div class="w-full h-[300px] rounded-2xl bg-[#F1F5FC] flex items-center justify-center text-[#6B7785]">--}}
{{--            <svg class="w-12 h-12 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"--}}
{{--                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v14.25a1.5 1.5 0 0 0 1.5 1.5Z"/>--}}
{{--            </svg>--}}
{{--        </div>--}}
    @endif
    @if(!empty($data['caption']))
        <figcaption class="mt-3 text-sm text-[#6B7785] text-center">{{ $data['caption'] }}</figcaption>
    @endif
</figure>
