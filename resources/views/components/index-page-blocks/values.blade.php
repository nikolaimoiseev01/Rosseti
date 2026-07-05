@php
    $economyItems = [
        ['type' => 'blue', 'text' => 'Стратегический партнер промышленности'],
        ['type' => 'light', 'text' => 'Вклад в технологический суверенитет страны'],
        ['type' => 'blue', 'text' => 'Ключевая инфраструктура'],
        ['type' => 'light', 'text' => 'Обеспечение растущих потребностей экономики<br>в энергоснабжении и энергобезопасности страны'],
        ['type' => 'blue', 'text' => 'Государственный актив'],
        ['type' => 'light', 'text' => 'Комплексный социально-экономический<br>эффект для государства'],
    ];

    $values = [
        [
            'title' => 'Надежность',
            'text' => 'Стремление к надежному и качественному обеспечению электроэнергией потребностей экономики и социального сектора России.',
        ],
        [
            'title' => 'Команда',
            'text' => 'Работники — ключевой ресурс. Компания ценит каждого работника, независимо от пола, возраста, национальности или должности, предоставляя равные возможности для работы, роста и профессионального развития.',
        ],
        [
            'title' => 'Эффективность',
            'text' => 'Непрерывное повышение эффективности деятельности через реализацию стратегических инициатив.',
        ],
        [
            'title' => 'Безопасность',
            'text' => 'Строго регламентированный и взвешенный подход к реализации мер безопасности, профилактика возможных правонарушений.',
        ],
        [
            'title' => 'Социальная ответственность',
            'text' => 'Поддержка социальных инициатив и реализация программ, направленных на благополучие работников и регионов присутствия, забота о безопасности труда, экологическая ответственность.',
        ],
    ];
@endphp

<section class="container py-8 text-[#0B4775]">
    <div class="grid grid-cols-2 gap-16 lg:grid-cols-1 lg:gap-10">
        <div>
            <h3 class="mb-7 text-[18px] font-semibold text-[#0B4775]">
                Группа «Россети» для экономики страны
            </h3>

            <div class="max-w-[540px]">
                @foreach($economyItems as $item)
                    <div class="relative">
                        <div
                            class="{{ $item['type'] === 'blue'
                                ? 'bg-[#2497E8] text-white'
                                : 'bg-[#F1F6FE] text-[#0B4775]'
                            }} flex min-h-[50px] items-center justify-center rounded-[6px] px-6 text-center text-[14px] leading-[1.35]"
                        >
                            {!! $item['text'] !!}
                        </div>

                        @if(!$loop->last && $item['type'] === 'light')
                            <div class="flex h-[10px] items-center justify-center text-[#2497E8]">
                                ⌄
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="mb-5 text-[18px] font-semibold text-[#0B4775]">
                Наши ценности
            </h3>

            <div class="relative space-y-5 pl-7 text-[14px] leading-[1.45] text-[#4A4A4A]">
                <div class="absolute left-[7px] top-1 bottom-3 w-px bg-[#BFD7EF]"></div>

                @foreach($values as $value)
                    <div class="relative">
                        <span class="absolute -left-[24px] top-1.5 flex h-[9px] w-[9px] items-center justify-center rounded-full border border-[#2497E8] bg-white">
                            <span class="h-[3px] w-[3px] rounded-full bg-[#2497E8]"></span>
                        </span>

                        <h4 class="mb-1 font-semibold text-[#0B4775]">
                            {{ $value['title'] }}
                        </h4>

                        <p>
                            {{ $value['text'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
