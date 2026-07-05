@php
    $tables = [
        [
            ['num' => 1, 'theme' => 'Обеспечение надежного и качественного электроснабжения', 'aspect' => 'Управленческий', 'priority' => 'Высокий'],
            ['num' => 2, 'theme' => 'Здоровье и безопасность на рабочем месте', 'aspect' => 'Социальный', 'priority' => 'Высокий'],
            ['num' => 3, 'theme' => 'Влияние на социально-экономическое развитие регионов присутствия', 'aspect' => 'Социальный', 'priority' => 'Высокий'],
            ['num' => 4, 'theme' => 'Забота о потребителях', 'aspect' => 'Социальный', 'priority' => 'Высокий'],
            ['num' => 5, 'theme' => 'Развитие кадрового потенциала', 'aspect' => 'Социальный', 'priority' => 'Высокий'],
            ['num' => 6, 'theme' => 'Обеспечение кибербезопасности и защиты данных', 'aspect' => 'Управленческий', 'priority' => 'Высокий'],
            ['num' => 7, 'theme' => 'Цифровые технологии', 'aspect' => 'Управленческий', 'priority' => 'Высокий'],
        ],
        [
            ['num' => 8, 'theme' => 'Соблюдение прав человека', 'aspect' => 'Социальный', 'priority' => 'Высокий'],
            ['num' => 9, 'theme' => 'НИОКР и внедрение инноваций', 'aspect' => 'Управленческий', 'priority' => 'Средний'],
            ['num' => 10, 'theme' => 'Обращение с отходами от производственной деятельности', 'aspect' => 'Экологический', 'priority' => 'Средний'],
            ['num' => 11, 'theme' => 'Реализация закупочной деятельности', 'aspect' => 'Управленческий', 'priority' => 'Средний'],
            ['num' => 12, 'theme' => 'Биоразнообразие', 'aspect' => 'Экологический', 'priority' => 'Средний'],
            ['num' => 13, 'theme' => 'Вклад в низкоуглеродное развитие и повышение энергоэффективности', 'aspect' => 'Экологический', 'priority' => 'Средний'],
            ['num' => 14, 'theme' => 'Воздействие на климат и меры адаптации к его изменениям', 'aspect' => 'Экологический', 'priority' => 'Средний'],
            ['num' => 15, 'theme' => 'Международная кооперация', 'aspect' => 'Управленческий', 'priority' => 'Средний'],
        ],
    ];
@endphp

<section class="container py-8 text-[#4A4A4A]">
    <h3 class="mb-6 text-center text-[20px] text-[#0060A8] md:text-left md:text-lg">
        Перечень существенных тем
    </h3>

    <div class="grid grid-cols-2 gap-5 lg:grid-cols-1">
        @foreach($tables as $rows)
            <table class="w-full border-collapse text-[14px] leading-[1.35]">
                <thead>
                <tr class="bg-[#2497E8] text-left text-white">
                    <th class="w-[36px] px-3 py-1.5 font-normal text-white"></th>
                    <th class="px-3 py-1.5 font-normal text-white">Тема</th>
                    <th class="w-[140px] px-3 py-1.5 font-normal text-white">Аспект</th>
                    <th class="w-[120px] px-3 py-1.5 font-normal text-white">Приоритет1</th>
                </tr>
                </thead>

                <tbody>
                @foreach($rows as $row)
                    <tr class="@if(!$loop->last) border-b border-[#B8B8B8] @endif">
                        <td class="p-3 align-top text-lg">{{ $row['num'] }}</td>

                        <td class="px-3 py-3 text-lg">
                            {{ $row['theme'] }}
                        </td>

                        <td class="px-3 py-3 text-lg align-top {{ $row['aspect'] === 'Экологический' ? 'text-[#008DFF]' : '' }}">
                            {{ $row['aspect'] }}
                        </td>

                        <td class="px-3 py-3 text-lg align-top {{ $row['priority'] === 'Высокий' ? 'text-[#008DFF]' : '' }}">
                            {{ $row['priority'] }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
</section>
