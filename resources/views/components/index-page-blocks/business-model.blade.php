@php
    $capitalSlides = [
        [
            'title' => 'Производственный (активы)',
            'subtitle' => 'Развитие и реновация инфраструктуры',
            'image' => '/fixed/aim-bg.jpg',
            'stats' => [
                ['value' => '2,6', 'unit' => 'млн км', 'text' => 'протяженность ЛЭП'],
                ['value' => '612', 'unit' => 'тыс. шт.', 'text' => 'количество подстанций'],
            ],
        ],
        [
            'title' => 'Природный',
            'subtitle' => 'Снижение потребления ресурсов и энергоэффективность',
            'image' => '/fixed/slider-card-1.2.jpg',
            'stats' => [
                ['value' => '10,0', 'unit' => 'млн ГДж', 'text' => 'объем потребления топливных ресурсов'],
                ['value' => '2 432', 'unit' => 'тыс. м³', 'text' => 'объем водопотребления', 'diff' => [['value' => '+1,7%', 'class' => '-top-[2px] right-[75px]']],],
            ],
        ],
        [
 'content' => <<<'HTML'
<div class="relative !h-[260px] !min-h-[260px] overflow-hidden rounded-[16px]
    bg-cover bg-center px-7 py-6 text-white
    shadow-[0_12px_25px_rgba(33,74,104,0.08)]"
    style="background-image: url('/fixed/slider-card-1.3.jpg');">

    <div class="absolute inset-0 bg-black-900/45"></div>

    <div class="relative z-10">
        <p class="mb-1 text-white">
           Социально-репутационный
        </p>

        <p class="text-white">
            Позитивная репутация Компании
        </p>
    </div>

    <div class="absolute bottom-7 left-7 right-7 z-10 grid grid-cols-4 gap-x-2 md:grid-cols-1">
        <div class='flex flex-col'>
            <span class='text-3xl text-white'>AAА (RU)</span>
            <p class="text-white">
                кредитный рейтинг от АКРА (АО)
            </p>
        </div>

        <div class='flex flex-col'>
            <span class='text-3xl text-white'>ruAAA </span>
            <p class="text-white">
                кредитный рейтинг от АО «Эксперт РА»
            </p>
        </div>
                <div class='flex flex-col'>
            <span class='text-3xl text-white'>ESG-2 (АА+)</span>
            <p class="text-white">
                ESG-рейтинг  от АКРА (АО)
            </p>
        </div>
                <div class='flex flex-col'>
            <span class='text-3xl text-white'>7++ </span>
            <p class="text-white">
                уровень рейтинга корпоративного управления
            </p>
        </div>
        <p class='text-white col-span-4'>Акции в 1-м котировальном списке Мосбиржи</p>
    </div>
</div>
HTML
        ],
                [
            'title' => 'Интеллектуальный',
            'subtitle' => 'Развитие научного и инновационного потенциала',
            'image' => '/fixed/slider-card-1.4.jpg',
            'stats' => [
                ['value' => '300+', 'unit' => '', 'text' => 'число партнеров среди вузов и ссузов'],
                ['value' => '1', 'unit' => '', 'text' => 'НИОКР передано в опытно-промышленную эксплуатацию'],
            ]
            ],
            [
            'title' => 'Финансовый',
            'subtitle' => 'Рост доходов и финансовая устойчивость',
            'image' => '/fixed/slider-card-1.5.jpg',
            'stats' => [
                ['value' => '1 906', 'unit' => 'млрд руб.', 'text' => 'собственный капитал '],
                ['value' => '829,7', 'unit' => 'млрд руб.', 'text' => 'заемные средства'],
            ],
        ],
               [
 'content' => <<<'HTML'
<div class="relative !h-[260px] !min-h-[260px] overflow-hidden rounded-[16px]
    bg-cover bg-center px-7 py-6 text-white
    shadow-[0_12px_25px_rgba(33,74,104,0.08)]"
    style="background-image: url('/fixed/slider-card-1.6.jpg');">

    <div class="absolute inset-0 bg-black-900/45"></div>

    <div class="relative z-10">
        <p class="mb-1 text-white">
           Человеческий (персонал)
        </p>

        <p class="text-white">
            Опыт и профессионализм, забота о персонале
        </p>
    </div>

    <div class="absolute bottom-7 left-7 left-7 z-10 flex flex-col md:grid-cols-1 max-w-[330px] ml-auto">
        <div class='flex items-end gap-2'>
        <span class='text-lg !text-white'>более</span>
        <span class='text-7xl text-white'>235</span>
        <span class='text-lg !text-white'>тыс. человек</span>
        </div>
        <p class=text-white>списочная численность работников всех компаний Группы «Россети» на 31.12.2025</p>
    </div>
</div>
HTML
        ],

    ];

        $resultSlides = [
            [
                'title' => 'Потребители',
                'stats' => [
                    ['value' => '837', 'diff' => [['value' => '-0,7%', 'class' => '-top-2 left-[50px]']], 'unit' => 'млрд кВт•ч', 'text' => 'объем переданной электроэнергии'],
                    ['value' => '14,7', 'diff' => [['value' => '-6,9%', 'class' => '-top-2 left-[50px]']], 'unit' => 'ГВт', 'text' => 'объем присоединенной мощности'],
                    ['value' => '2,4 SAIDI<br>1,2 SAIFI', 'diff' => [['value' => '-11%', 'class' => 'top-2 right-[30px]'], ['value' => '-7%', 'class' => 'top-10 right-[30px]']], 'unit' => '', 'text' => ''],
                    ['value' => '35', 'unit' => 'тыс. км', 'diff' => [['value' => '+200%', 'class' => '-top-2 left-[50px]']], 'text' => 'увеличение протяженности ЛЭП'],
                    ['value' => '15', 'unit' => 'тыс. МВА', 'diff' => [['value' => '+55%', 'class' => '-top-2 left-[50px]']], 'text' => 'ввод новых мощностей подстанций'],
                    ['value' => '2 880', 'unit' => 'МВт•ч Пens', 'text' => ''],
                ],
            ],
                        [
                'title' => 'Работники',
                'stats' => [
                    ['value' => '371,6', 'diff' => [['value' => '+15%', 'class' => '-top-2 left-[80px]']], 'unit' => 'млрд руб.', 'text' => 'совокупный объем расходов<br>на вознаграждение<br>работников Группы'],
                    ['value' => '10,8', 'unit' => 'млрд руб.', 'text' => 'объем расходов <br>на охрану труда'],
                   ['value' => '1,36', 'unit' => 'млрд руб.', 'text' => 'затраты на обучение<br>персонала'],
                    ['title' => 'Акционеры и инвесторы'],
                    ['value' => '1 834', 'unit' => 'млрд  руб.', 'text' => 'выручка'],
                    ['prefix' => 'более', 'value' => '203', 'unit' => 'млрд руб.', 'text' => 'чистая прибыль'],
                ],
            ],
                        [
                'title' => 'Партнеры',
                'stats' => [
                    ['value' => '472', 'diff' => [['value' => '-12%', 'class' => '-top-2 left-[50px]']], 'unit' => 'млрд руб.', 'text' => 'объем закупок у субъектов МСП'],
                    ['value' => '1,7', 'unit' => 'трлн руб. с НДС ', 'text' => 'общая сумма закупок'],
                   ['skip_block' => true],
                    ['title' => 'Государство'],
                    ['value' => '270', 'unit' => 'млрд руб.',  'diff' => [['value' => '-4%', 'class' => '-top-2 left-[50px]']], 'text' => 'налоговые и социальные отчисления'],
                    ['value' => '725', 'unit' => 'млрд руб.', 'text' => 'инвестиции в электросетевые активы'],
                ],
                ],
                [
                'title' => 'Вклад в реализацию национальных проектов',
                'class' => 'grid-cols-6 grid-rows-2',
                'slide_number' => 3,
                'img_class' => '',
                'imgs' => 12,
            ],
                            [
                'title' => 'Вклад в достижение ЦУР ООН',
                'subtitle' => 'Компания разделяет все ЦУР ООН и вносит посильный вклад в их достижение',
                'class' => 'grid-cols-8 grid-rows-2',
                'slide_number' => 4,
                'img_class' => 'w-[60px] min-w-[60px]',
                'imgs' => 10,
            ],
        ];
@endphp

<section x-data="revealOnScroll()" class="page-block page-block--business-model container py-10 ">
    <h2 x-data="revealOnScroll()" class="mb-4 text-5xl text-blue-900 uppercase leading-none md:text-[26px]">
        Бизнес-модель
    </h2>

    <p x-data="revealOnScroll()" class="mb-6 max-w-[609px] text-[#4A4A4A]">
        Оказание услуг по передаче электроэнергии, технологическому присоединению потребителей,
        строительству и реконструкции электросетевых объектов — основные виды экономической деятельности Компании.
    </p>

    <div class="flex flex-col gap-8 lg:flex-col">
        <div class="flex lg:flex-col gap-8 mb-4">
            <div class=" w-1/2 lg:w-full">
                <h3 x-data="revealOnScroll()" class="mb-2 text-2xl">
                    Капиталы (ресурсы)
                </h3>

                <p x-data="revealOnScroll()" class="">
                    Ресурсы, используемые в цепочке создания стоимости, сгруппированы в шесть капиталов:
                    человеческий, производственный, финансовый, интеллектуальный, социально-репутационный и природный.
                </p>
            </div>
            <div class=" w-1/2 lg:w-full">
                <h3 x-data="revealOnScroll()" class="mb-2 text-2xl">
                    Результаты для заинтересованных сторон
                </h3>

                <p x-data="revealOnScroll()" class="">
                    В результате деятельности Компании происходит трансформация капиталов и создание ценности для внешних и внутренних заинтересованных сторон.
                </p>
            </div>
        </div>

        <div class="flex lg:flex-col gap-8 mb-8">
            <div class="flex flex-col gap-6 w-1/2 lg:w-full">
                @foreach($capitalSlides as $slide)
                    <div x-data="revealOnScroll()">
                        @if(isset($slide['content']))
                            {!! $slide['content'] !!}
                        @else
                            <div class="relative !h-[260px] !min-h-[260px] overflow-hidden rounded-[16px] bg-cover bg-center px-7 py-6 text-white shadow-[0_12px_25px_rgba(33,74,104,0.08)]"
                                 style="background-image: url('{{ $slide['image'] }}');">
                                <div class="absolute inset-0 bg-black-900/10"></div>
                                <div class="relative z-10">
                                    <p class="mb-1 text-white">{{ $slide['title'] }}</p>
                                    <p class="text-white">{{ $slide['subtitle'] }}</p>
                                </div>
                                <div class="absolute bottom-7 left-7 right-7 z-10 grid grid-cols-2 gap-8 md:grid-cols-1 lg:flex">
                                    @foreach($slide['stats'] as $stat)
                                        <div>
                                            <div class="relative flex items-end gap-2">
                                                <span class="text-7xl leading-[50px] text-white">{{ $stat['value'] }}</span>
                                                @if($stat['diff'] ?? null)
                                                    @foreach($stat['diff'] as $diff)
                                                        <span class="absolute rounded-full bg-white px-2 text-[10px] text-green-300 {{ $diff['class'] }}">{{ $diff['value'] }}</span>
                                                    @endforeach
                                                @endif
                                                <span class="text-white">{{ $stat['unit'] }}</span>
                                            </div>
                                            <p class="text-white">{{ $stat['text'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col gap-6 w-1/2 lg:w-full">
                @foreach($resultSlides as $slide)
                    <div x-data="revealOnScroll()">
                        @if(isset($slide['content']))
                            {!! $slide['content'] !!}
                        @elseif(isset($slide['imgs']))
                            <div class="h-[260px] rounded-[16px] bg-[#F1F6FE] px-8 py-8 shadow-[0_12px_25px_rgba(33,74,104,0.08)] md:h-auto">
                                <h4 class="mb-2 text-lg text-blue-900">{{ $slide['title'] }}</h4>
                                @if($slide['subtitle'] ?? null)
                                    <p class="mb-2 text-sm ">{{ $slide['subtitle'] }}</p>
                                @endif
                                <div class="grid gap-4">
                                    <img src="/fixed/slider-card-2.{{ $slide['slide_number'] }}.png" alt="">
                                </div>
                            </div>
                        @else
                            <div class="h-[260px] rounded-[16px] bg-[#F1F6FE] px-8 py-8 shadow-[0_12px_25px_rgba(33,74,104,0.08)] md:h-auto">
                                <h4 class="mb-5 text-lg text-blue-900">{{ $slide['title'] }}</h4>
                                <div class="grid grid-cols-3 gap-x-8 gap-y-5">
                                    @foreach($slide['stats'] as $stat)
                                        @if($stat['skip_block'] ?? null)
                                            <div></div>
                                        @elseif($stat['title'] ?? null)
                                            <p class="text-blue-900 text-nowrap">{{$stat['title']}}</p>
                                        @else
                                            <div>
                                                <div class="relative flex items-baseline gap-2">
                                                    @if($stat['diff'] ?? null)
                                                        @foreach($stat['diff'] as $diff)
                                                            <span class="absolute rounded-full bg-white px-2 text-[10px] text-green-300 {{ $diff['class'] }}">{{ $diff['value'] }}</span>
                                                        @endforeach
                                                    @endif
                                                    <div class="flex gap-2 items-end">
                                                        @if($stat['prefix'] ?? null)
                                                            <div class="mt-1 text-lg text-blue-400">{{ $stat['prefix'] }}</div>
                                                        @endif
                                                        <div class="text-3xl text-blue-400">{!! $stat['value'] !!}</div>
                                                    </div>
                                                    @if($stat['unit'])
                                                        <div class="mt-1 text-lg text-blue-400">{{ $stat['unit'] }}</div>
                                                    @endif
                                                </div>
                                                @if($stat['text'])
                                                    <p class="mt-1 text-sm leading-[14px]">{!! $stat['text'] !!}</p>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
