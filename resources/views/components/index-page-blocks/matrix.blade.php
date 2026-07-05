@php
    $legendGroups = [
        [
            'title' => 'Экологический аспект',
            'color' => '#027E66',
            'items' => [
                [1, 'Вклад в низкоуглеродное развитие и повышение энергоэффективности'],
                [2, 'Воздействие на климат и меры адаптации к его изменениям'],
                [3, 'Обращение с отходами от производственной деятельности'],
                [4, 'Биоразнообразие'],
            ],
        ],
        [
            'title' => 'Социальный аспект',
            'color' => '#2497E8',
            'items' => [
                [5, 'Влияние на социально-экономическое развитие регионов присутствия'],
                [6, 'Развитие кадрового потенциала'],
                [7, 'Здоровье и безопасность на рабочем месте'],
                [8, 'Соблюдение прав человека'],
                [9, 'Забота о потребителях'],
            ],
        ],
        [
            'title' => 'Управленческий аспект',
            'color' => '#516B80',
            'items' => [
                [10, 'Обеспечение надежного и бесперебойного электроснабжения потребителей'],
                [11, 'Обеспечение кибербезопасности и защиты данных'],
                [12, 'Реализация закупочной деятельности'],
                [13, 'НИОКР и внедрение инноваций'],
                [14, 'Цифровые технологии'],
                [15, 'Международная кооперация'],
            ],
        ],
    ];

    $charts = [
        ['n' => 1, 'x' => '56%', 'y' => '48%', 'color' => '#00A99D'],
        ['n' => 2, 'x' => '45%', 'y' => '48%', 'color' => '#00A99D'],
        ['n' => 3, 'x' => '50%', 'y' => '40%', 'color' => '#00A99D'],
        ['n' => 4, 'x' => '51%', 'y' => '62%', 'color' => '#00A99D'],
        ['n' => 5, 'x' => '78%', 'y' => '16%', 'color' => '#2497E8'],
        ['n' => 6, 'x' => '67%', 'y' => '25%', 'color' => '#2497E8'],
        ['n' => 7, 'x' => '70%', 'y' => '08%', 'color' => '#2497E8'],
        ['n' => 8, 'x' => '78%', 'y' => '22%', 'color' => '#2497E8'],
        ['n' => 9, 'x' => '73%', 'y' => '20%', 'color' => '#2497E8'],
        ['n' => 10, 'x' => '82%', 'y' => '06%', 'color' => '#516B80'],
        ['n' => 11, 'x' => '46%', 'y' => '28%', 'color' => '#516B80'],
        ['n' => 12, 'x' => '63%', 'y' => '22%', 'color' => '#516B80'],
        ['n' => 13, 'x' => '66%', 'y' => '22%', 'color' => '#516B80'],
        ['n' => 14, 'x' => '66%', 'y' => '31%', 'color' => '#516B80'],
        ['n' => 15, 'x' => '33%', 'y' => '33%', 'color' => '#516B80'],
    ];

    $topTables = [
        [
            'title' => 'Топ-3 темы по степени важности для каждой из групп заинтересованных сторон',
            'rows' => [
                ['Обеспечение надежного и бесперебойного электроснабжения', 'Обеспечение надежного и бесперебойного электроснабжения'],
                ['Влияние на социально-экономическое развитие регионов присутствия', 'Здоровье и безопасность на рабочем месте'],
                ['Забота о потребителях', 'Развитие кадрового потенциала'],
            ],
        ],
        [
            'title' => 'Топ-3 темы по степени влияния на них Компании по мнению каждой из групп заинтересованных сторон',
            'rows' => [
                ['Обеспечение надежного и бесперебойного электроснабжения', 'Обеспечение надежного и бесперебойного электроснабжения'],
                ['Здоровье и безопасность на рабочем месте', 'Здоровье и безопасность на рабочем месте'],
                ['Забота о потребителях', 'Забота о потребителях'],
            ],
        ],
        [
            'title' => 'Топ-3 темы по степени ожидания их раскрытия в Отчете по мнению каждой из групп заинтересованных сторон',
            'rows' => [
                ['Обеспечение надежного и бесперебойного электроснабжения', 'Обеспечение надежного и бесперебойного электроснабжения'],
                ['Влияние на социально-экономическое развитие регионов присутствия', 'Здоровье и безопасность на рабочем месте'],
                ['Забота о потребителях', 'Развитие кадрового потенциала'],
            ],
        ],
    ];
@endphp

<section class="container py-10 text-[#4A4A4A]">
    <div class="grid grid-cols-[1fr_0.95fr] gap-6 lg:grid-cols-1">
        <div>
            <h2 class="mb-4 text-[34px] leading-none uppercase  lg:text-[28px] md:text-[24px]">
                Матрица существенных тем
            </h2>

            <div class="overflow-hidden rounded-b-[14px]">
                <div class="rounded-t-[14px] bg-white px-6 pb-6">
                    <img src="/fixed/matrix-chart.png" alt="">

                    <div class="grid grid-cols-2 gap-x-8 gap-y-5 text-[12px] leading-[1.15] md:grid-cols-1">
                        @foreach($legendGroups as $group)
                            <div class="{{ $loop->last ? 'col-span-2 md:col-span-1' : '' }}">
                                <h4 class="mb-3 font-medium text-lg" style="color: {{ $group['color'] }}">
                                    {{ $group['title'] }}
                                </h4>

                                <div class="grid grid-cols-2 gap-x-6 gap-y-2 {{ $loop->last ? '' : 'md:grid-cols-1' }}">
                                    @foreach($group['items'] as [$number, $text])
                                        <div class="flex gap-2">
                                            <span
                                                class="mt-0.5 flex h-[14px] w-[14px] shrink-0 items-center justify-center rounded-full border text-[8px] font-semibold"
                                                style="border-color: {{ $group['color'] }}; color: {{ $group['color'] }};"
                                            >
                                                {{ $number }}
                                            </span>
                                            <span>{{ $text }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-start gap-4 rounded-b-[14px] bg-[#2497E8] px-6 py-5 text-[14px] leading-[1.35] text-white">
                    <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-white text-[11px] text-[#2497E8]">
                        ✓
                    </span>
                    <p>
                        Внутренние заинтересованные стороны оценили существенность заявленных тем Компании
                        в среднем на 10% выше внешних заинтересованных сторон.
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-6 pt-1">
            @foreach($topTables as $table)
                <div>
                    <h3 class="mb-4 text-[18px] font-semibold leading-[1.25] text-[#0060A8]">
                        {{ $table['title'] }}
                    </h3>

                    <table class="w-full border-collapse text-[13px] leading-[1.35]">
                        <thead>
                        <tr class="bg-[#2497E8] text-left text-white">
                            <th class="w-1/2 px-4 py-1.5 font-normal">Внешние стейкхолдеры</th>
                            <th class="w-1/2 px-4 py-1.5 font-normal">Внутренние стейкхолдеры</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($table['rows'] as [$external, $internal])
                            <tr class="border-b border-[#B8B8B8]">
                                <td class="px-4 py-3 align-top">{{ $external }}</td>
                                <td class="px-4 py-3 align-top">{{ $internal }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</section>
