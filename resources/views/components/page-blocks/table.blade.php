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
        default => 'text-[#1A1A1A]',
    };
    $colCount = count($data['headers'] ?? []);
@endphp

@if(!empty($data['caption']))
    <p class="text-sm font-bold text-[#00355A] mb-2">{{ $data['caption'] }}</p>
@endif

<div class="overflow-x-auto rounded-xl border border-[#E1E7F0]">
    <table class="w-full text-sm">
        @if(!empty($data['headers']))
            <thead>
                <tr class="{{ $headerBg }}">
                    @foreach($data['headers'] as $header)
                        <th class="{{ $cellPadding }} text-left font-bold" @if($headerStyle === 'blue') style="color: #fff;" @endif>{{ $header['text'] }}</th>
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
