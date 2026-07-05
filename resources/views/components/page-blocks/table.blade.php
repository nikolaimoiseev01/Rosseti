{{-- Table Block --}}
<div class="overflow-x-auto">
    @if(!empty($data['caption']))
        <h4 class="text-lg font-bold text-[#1A1A1A] mb-4">{{ $data['caption'] }}</h4>
    @endif
    <table class="w-full text-sm border-collapse">
        @if(!empty($data['headers']))
            <thead>
                <tr class="bg-[#005B9C] text-white">
                    @foreach($data['headers'] as $header)
                        <th class="px-5 py-3 text-left font-bold">{{ $header['text'] }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @foreach($data['rows'] ?? [] as $rowIndex => $row)
                <tr class="{{ $rowIndex % 2 === 0 ? 'bg-[#F7F9FC]' : 'bg-white' }} border-b border-[#E1E7F0]">
                    @foreach($row['cells'] ?? [] as $cell)
                        <td class="px-5 py-3 text-[#333]">{{ $cell['text'] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
