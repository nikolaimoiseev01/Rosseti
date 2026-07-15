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
            'class' => '!grid !grid-cols-2',
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

<section class="page-block page-block--matrix container py-10 text-[#4A4A4A] mb-28 md:mb-16">
    <div class="grid grid-cols-[1fr_0.95fr] gap-6 lg:grid-cols-1 lg:gap-32 md:!gap-48">
        <div>
            <h2 x-data="revealOnScroll()" class="mb-4 text-[34px] leading-none uppercase  lg:text-[28px] md:text-[24px]">
                Матрица существенных тем
            </h2>

            <div x-data="revealOnScroll()" class="rounded-b-[14px] relative">
                <div class="rounded-2xl bg-white px-6 pb-6 rounded-3xl">
                    <img src="/fixed/matrix-chart.png" class="mb-3" alt="">

                    <div class="grid grid-cols-2 gap-x-8 gap-y-5 text-[12px] leading-[1.15] md:grid-cols-1">
                        @foreach($legendGroups as $group)
                            <div class="{{ $loop->last ? 'col-span-2 md:col-span-1' : '' }}">
                                <h4 class="mb-3 font-medium text-lg" style="color: {{ $group['color'] }}">
                                    {{ $group['title'] }}
                                </h4>

                                <div
                                    class="flex flex-col {{$group['class'] ?? ''}} gap-x-6 gap-y-2 {{ $loop->last ? '' : 'md:grid-cols-1' }}">
                                    @foreach($group['items'] as [$number, $text])
                                        <div class="flex gap-2">
                                            <div
                                                class="relative flex items-center justify-center w-[18px] min-w-[18px] bg-white h-[18px] border rounded-full"
                                                style="border-color: {{ $group['color'] }};">
                                                <span
                                                    class="flex h-3 w-3 shrink-0 items-center justify-center pt-[2px] rounded-full text-[8px] font-semibold text-white"
                                                    style="background: {{ $group['color'] }};"
                                                >
                                                    {{ $number }}

                                                </span>
                                                @if(!$loop->last)
                                                    <div
                                                        class="w-px h-[150%] absolute top-full bg-gradient-to-b from-blue-400 to-transparent"></div>
                                                @endif
                                            </div>
                                            <span class="text-base leading-[16px]">{{ $text }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div
                        class="flex items-start  gap-3 rounded-b-[14px] left-0 bg-blue-400 absolute top-[97%] -z-[1] px-6 pb-5 pt-12 text-[14px] leading-[1.35] text-white">
                        <svg class="min-w-6 min-h-6" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="11.5" fill="white" fill-opacity="0.2"/>
                            <path d="M11.5 3C6.81291 3 3 6.81291 3 11.5C3 16.1871 6.81291 20 11.5 20C16.1871 20 20 16.1871 20 11.5C20 6.81291 16.1871 3 11.5 3Z" fill="white"/>
                            <path d="M15.808 9.70151L11.2037 14.3056C11.0656 14.4437 10.8843 14.5132 10.703 14.5132C10.5217 14.5132 10.3403 14.4437 10.2022 14.3056L7.90016 12.0035C7.62312 11.7266 7.62312 11.2789 7.90016 11.002C8.17707 10.725 8.62466 10.725 8.9017 11.002L10.703 12.8033L14.8064 8.69997C15.0833 8.42293 15.5309 8.42293 15.808 8.69997C16.0849 8.97688 16.0849 9.42447 15.808 9.70151Z" fill="#2196F3"/>
                        </svg>
                        <p class="text-white">
                            Внутренние заинтересованные стороны оценили существенность заявленных тем Компании
                            в среднем на 10% выше внешних заинтересованных сторон.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div x-data="revealOnScroll()" class="space-y-6 pt-1">
            @foreach($topTables as $table)
                <div class="md:overflow-scroll">
                    <h3 class="mb-4 text-2xl leading-[1.25] text-[#0060A8]">
                        {{ $table['title'] }}
                    </h3>

                    <table class="w-full border-collapse text-[13px] leading-[1.35]">
                        <thead>
                        <tr class="bg-[#2497E8] text-left text-white">
                            <th class="w-1/2 px-4 font-normal text-white text-lg">Внешние стейкхолдеры</th>
                            <th class="w-1/2 px-4 font-normal text-white text-lg">Внутренние стейкхолдеры</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($table['rows'] as [$external, $internal])
                            <tr class="border-b border-[#B8B8B8]">
                                <td class="px-4 py-3 align-top leading-6 text-lg">{{ $external }}</td>
                                <td class="px-4 py-3 align-top leading-6 text-lg">{{ $internal }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</section>
