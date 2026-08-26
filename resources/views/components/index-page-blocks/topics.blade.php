@php
    $tables = [
        [
            ['num' => 1, 'theme' => __('Обеспечение надежного и качественного электроснабжения'), 'aspect' => __('Управленческий'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
            ['num' => 2, 'theme' => __('Здоровье и безопасность на рабочем месте'), 'aspect' => __('Социальный'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
            ['num' => 3, 'theme' => __('Влияние на социально-экономическое развитие регионов присутствия'), 'aspect' => __('Социальный'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
            ['num' => 4, 'theme' => __('Забота о потребителях'), 'aspect' => __('Социальный'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
            ['num' => 5, 'theme' => __('Развитие кадрового потенциала'), 'aspect' => __('Социальный'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
            ['num' => 6, 'theme' => __('Обеспечение кибербезопасности и защиты данных'), 'aspect' => __('Управленческий'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
            ['num' => 7, 'theme' => __('Цифровые технологии'), 'aspect' => __('Управленческий'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
        ],
        [
            ['num' => 8, 'theme' => __('Соблюдение прав человека'), 'aspect' => __('Социальный'), 'priority' => __('Высокий'), 'priority_level' => 'high'],
            ['num' => 9, 'theme' => __('НИОКР и внедрение инноваций'), 'aspect' => __('Управленческий'), 'priority' => __('Средний')],
            ['num' => 10, 'theme' => __('Обращение с отходами от производственной деятельности'), 'aspect' => __('Экологический'), 'priority' => __('Средний')],
            ['num' => 11, 'theme' => __('Реализация закупочной деятельности'), 'aspect' => __('Управленческий'), 'priority' => __('Средний')],
            ['num' => 12, 'theme' => __('Биоразнообразие'), 'aspect' => __('Экологический'), 'priority' => __('Средний')],
            ['num' => 13, 'theme' => __('Вклад в низкоуглеродное развитие и повышение энергоэффективности'), 'aspect' => __('Экологический'), 'priority' => __('Средний')],
            ['num' => 14, 'theme' => __('Воздействие на климат и меры адаптации к его изменениям'), 'aspect' => __('Экологический'), 'priority' => __('Средний')],
            ['num' => 15, 'theme' => __('Международная кооперация'), 'aspect' => __('Управленческий'), 'priority' => __('Средний')],
        ],
    ];
@endphp

<section x-data="revealOnScroll()" class="page-block page-block--topics container mb-24 text-[#4A4A4A]">
    <h3 x-data="revealOnScroll()" class="mb-6 text-center text-2xl text-[#0060A8] md:text-left md:text-lg">
        {{ __('Перечень существенных тем') }}
    </h3>

    <div x-data="revealOnScroll()" class="grid grid-cols-2 gap-5 lg:grid-cols-1 lg:overflow-scroll">
        @foreach($tables as $rows)
            <table class="w-full border-collapse text-[14px] leading-[1.35]">
                <thead>
                <tr class="bg-[#2497E8] text-left text-lg text-white">
                    <th class="w-[36px] px-3 py-1.5 font-normal text-white"></th>
                    <th class="px-3 py-1.5 font-normal text-white">{{ __('Тема') }}</th>
                    <th class="w-[140px] px-3 py-1.5 font-normal text-white">{{ __('Аспект') }}</th>
                    <th class="w-[120px] px-3 py-1.5 font-normal text-white">
                        <span class="has-tooltip !text-white" data-tooltip="На основе средней оценки по трем критериям, где < 3 — низкий приоритет, 3-4 — средний приоритет,  4 -5 —высокий приоритет" aria-label="На основе средней оценки по трем критериям, где < 3 — низкий приоритет, 3-4 — средний приоритет,  4 -5 —высокий приоритет" data-alpine-devtools-right-click="">{{ __('Приоритет') }}</span>
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach($rows as $row)
                    <tr class="@if(!$loop->last) border-b border-[#B8B8B8] @endif">
                        <td class="p-3 align-top leading-6 text-lg">{{ $row['num'] }}</td>

                        <td class="px-3 py-3 pt-1.5  text-lg">
                            {{ $row['theme'] }}
                        </td>

                        <td class="px-3 py-3 pt-1.5  text-lg align-top {{ $row['aspect'] === 'Экологический' ? 'text-[#008DFF]' : '' }} {{ $row['aspect'] === 'Социальный' ? 'text-blue-900' : '' }}">
                            {{ $row['aspect'] }}
                        </td>

                        <td class="px-3 py-3 text-lg align-top {{ ($row['priority_level'] ?? 'medium') === 'high' ? 'text-[#008DFF]' : '' }}">
                            {{ $row['priority'] }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
</section>
