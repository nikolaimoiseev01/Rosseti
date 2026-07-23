{{-- Table Block --}}
@php
    $headerStyle = $data['header_style'] ?? 'blue';
    $cellPadding = match($data['cell_padding'] ?? 'normal') {
        'compact' => 'px-2 py-1',
        'spacious' => 'px-6 py-4',
        default => 'px-4 py-3',
    };
    $headerBg = match($headerStyle) {
        'blue' => 'bg-[#00355A] text-white',
        'light' => 'bg-[#F0F4F8] text-[#1A1A1A]',
        'dark' => 'bg-[#1B2733] text-white',
        default => 'text-[#1A1A1A]',
    };
    $headerFontStyle = match($data['header_font_style'] ?? 'bold') {
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'bold' => 'font-bold',
        default => 'font-bold',
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
    $colCount = count($data['headers'] ?? []);
@endphp

@if(!empty($data['caption']))
    <p class="text-sm font-bold text-[#00355A] mb-2">{{ $data['caption'] }}</p>
@endif

<div x-data="revealOnScroll()" class="page-block page-block--table overflow-x-auto rounded-xl border border-[#E1E7F0] {{ $spacingTop }} {{ $spacingBottom }}">
    <table class="w-full text-sm">
        @if(!empty($data['headers']))
            <thead>
                <tr class="{{ $headerBg }}">
                    @foreach($data['headers'] as $header)
                        <th class="{{ $cellPadding }} {{ $headerFontStyle }} text-left" @if($headerStyle === 'blue' || $headerStyle === 'dark') style="color: #fff;" @endif>{{ $header['text'] }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @foreach($data['rows'] ?? [] as $index => $row)
                @if(!empty($row['is_accent']))
                    <tr>
                        <td colspan="{{ $colCount }}" class="bg-[#2196F3] text-white font-bold {{ $cellPadding }}">
                            {{ $row['accent_text'] ?? '' }}
                        </td>
                    </tr>
                @else
                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#F7F9FC]' }}">
                        @foreach($row['cells'] ?? [] as $cell)
                            <td class="{{ $cellPadding }} text-[#333] border-t border-[#E1E7F0]">{{ $cell['text'] }}</td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
