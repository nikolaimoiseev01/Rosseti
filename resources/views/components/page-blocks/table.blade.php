{{-- Table Block --}}
@php
    $headerStyle = $data['header_style'] ?? 'blue';
    $cellPadding = match($data['cell_padding'] ?? 'normal') {
        'compact' => 'px-2 py-1',
        'spacious' => 'px-6 py-4',
        default => 'px-4 py-3',
    };
    $headerBg = match($headerStyle) {
        'blue' => 'bg-blue-600',
        'light' => 'bg-[#F0F4F8]',
        default => '',
    };
    $colCount = count($data['headers'] ?? []);
@endphp

@if(!empty($data['caption']))
    <p class="text-sm font-bold text-blue-600 mb-2">{{ $data['caption'] }}</p>
@endif

<div class="overflow-x-auto rounded-xl border border-[#E1E7F0]">
    <table class="w-full text-sm">
        @if(!empty($data['headers']))
            <thead>
                <tr class="{{ $headerBg }}">
                    @foreach($data['headers'] as $header)
                        <th class="{{ $cellPadding }} text-left font-bold" @if($headerStyle === 'blue') style="color: #fff;" @else style="color: #1A1A1A;" @endif>{{ $header['text'] }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @foreach($data['rows'] ?? [] as $index => $row)
                @if(!empty($row['is_accent']))
                    <tr>
                        <td colspan="{{ $colCount }}" class="bg-blue-400 font-bold {{ $cellPadding }}" style="color: #fff;">
                            {{ $row['accent_text'] ?? '' }}
                        </td>
                    </tr>
                @else
                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#F7F9FC]' }}">
                        @foreach($row['cells'] ?? [] as $cell)
                            <td class="{{ $cellPadding }} text-black-500 border-t border-[#E1E7F0] prose prose-sm max-w-none">{!! $cell['text'] !!}</td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
