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
                    ['value' => '2 880', 'unit' => 'МВт•ч I-ens', 'text' => ''],
                ],
            ],
                        [
                'title' => 'Работники',
                'stats' => [
                    ['value' => '371,6', 'diff' => [['value' => '+15%', 'class' => '-top-2 left-[50px]']], 'unit' => 'млрд руб.', 'text' => 'совокупный объем расходов на вознаграждение  работников Группы'],
                    ['value' => '14,7', 'diff' => [['value' => '-6,9%', 'class' => '-top-2 left-[50px]']], 'unit' => 'ГВт', 'text' => 'объем расходов  на охрану труда'],
                   ['value' => '1,36', 'diff' => [['value' => '-6,9%', 'class' => '-top-2 left-[50px]']], 'unit' => 'млрд руб.', 'text' => 'затраты на обучение  персонала'],
                    ['title' => 'Акционеры и инвесторы'],
                    ['value' => '1 834', 'unit' => 'млрд  руб.', 'text' => 'выручка'],
                    ['value' => '203', 'unit' => 'млрд руб.', 'text' => 'чистая прибыль'],
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

<style>
    .business-stack-swiper {
        position: relative;
        height: 315px;
        overflow: visible;
    }

    .business-stack-swiper .swiper-wrapper {
        position: relative;
        width: 100%;
        height: 280px;
        transform: none !important;
    }

    .business-stack-swiper .swiper-slide {
        position: absolute;
        top: 0;
        left: 0;

        width: 100%;
        height: 260px;

        opacity: 0;
        pointer-events: none;
        transform-origin: center top;

        transition: transform 0.5s ease,
        opacity 0.5s ease;
    }

    .business-stack-swiper .swiper-slide.is-stack-visible {
        opacity: 1;
    }

    .business-stack-swiper .swiper-slide.is-active-card {
        pointer-events: auto;
    }

    .business-capitals-swiper .swiper-slide > div {
        transition: filter 0.5s ease,
        box-shadow 0.5s ease;
    }

    .business-capitals-swiper .swiper-slide.is-stack-depth-1 > div {
        filter: blur(1.5px) brightness(0.75);
        box-shadow: 0 16px 28px rgba(33, 74, 104, 0.2);
    }

    .business-capitals-swiper .swiper-slide.is-stack-depth-2 > div {
        filter: blur(3px) brightness(0.6);
        box-shadow: 0 20px 36px rgba(33, 74, 104, 0.24);
    }

    .business-capitals-swiper .swiper-slide.is-active-card > div {
        filter: none;
        box-shadow: 0 12px 25px rgba(33, 74, 104, 0.08);
    }

    @media (max-width: 767px) {
        .business-stack-swiper {
            height: auto;
            overflow: hidden;
        }

        .business-stack-swiper .swiper-wrapper {
            height: auto;
            min-height: 500px;
        }

        .business-stack-swiper .swiper-slide {
            height: auto;
        }

        .business-capitals-swiper .swiper-wrapper {
            min-height: 320px;
        }
    }
</style>

<section x-data="revealOnScroll()" class="page-block page-block--business-model container py-10 ">
    <h2 x-data="revealOnScroll()" class="mb-4 text-5xl text-blue-900 uppercase leading-none md:text-[26px]">
        Бизнес-модель
    </h2>

    <p x-data="revealOnScroll()" class="mb-6 max-w-[609px] text-[#4A4A4A]">
        Оказание услуг по передаче электроэнергии, технологическому присоединению потребителей,
        строительству и реконструкции электросетевых объектов — основные виды экономической деятельности Компании.
    </p>

    <div class="grid grid-cols-2 gap-8 lg:grid-cols-1">
        <div>
            <h3 x-data="revealOnScroll()" class="mb-2 text-2xl">
                Капиталы (ресурсы)
            </h3>

            <p x-data="revealOnScroll()" class="mb-8">
                Ресурсы, используемые в цепочке создания стоимости, сгруппированы в шесть капиталов:
                человеческий, производственный, финансовый, интеллектуальный, социально-репутационный и природный.
            </p>

            <div
                x-data="revealOnScroll()"
                class="business-stack-slider relative"
            >
                <div class="swiper business-stack-swiper business-capitals-swiper">
                    <div class="swiper-wrapper">
                        @foreach($capitalSlides as $slide)
                            <div class="swiper-slide">
                                @if(isset($slide['content']))
                                    {!! $slide['content'] !!}
                                @else
                                    <div
                                        class="relative !h-[260px] !min-h-[260px] overflow-hidden rounded-[16px]
                                   bg-cover bg-center px-7 py-6 text-white
                                   shadow-[0_12px_25px_rgba(33,74,104,0.08)]"
                                        style="background-image: url('{{ $slide['image'] }}');"
                                    >
                                        <div class="absolute inset-0 bg-black-900/10"></div>

                                        <div class="relative z-10">
                                            <p class="mb-1 text-white">
                                                {{ $slide['title'] }}
                                            </p>

                                            <p class="text-white">
                                                {{ $slide['subtitle'] }}
                                            </p>
                                        </div>

                                        <div
                                            class="absolute bottom-7 left-7 right-7 z-10
                                       grid grid-cols-2 gap-8 md:grid-cols-1"
                                        >
                                            @foreach($slide['stats'] as $stat)
                                                <div>
                                                    <div class="relative flex items-end gap-2">
                                            <span class="text-7xl leading-[50px] text-white">
                                                {{ $stat['value'] }}
                                            </span>

                                                        @if($stat['diff'] ?? null)
                                                            @foreach($stat['diff'] as $diff)
                                                                <span
                                                                    class="absolute rounded-full bg-white px-2
                                                               text-[10px] text-green-300
                                                               {{ $diff['class'] }}"
                                                                >
                                                                {{ $diff['value'] }}
                                                            </span>
                                                            @endforeach
                                                        @endif

                                                        <span class="text-white">
                                                {{ $stat['unit'] }}
                                            </span>
                                                    </div>

                                                    <p class="text-white">
                                                        {{ $stat['text'] }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 flex justify-center gap-4">
                    <button
                        type="button"
                        class="business-stack-prev flex h-12 w-12 items-center justify-center
                   rounded-full border border-[#D8ECFF]
                   text-[28px] text-[#2497E8]
                   disabled:opacity-40
                                                 transition-all duration-300 ease-out
           hover:border-[#2497E8]
           hover:bg-[#2497E8]
           hover:text-white
           hover:shadow-[0_10px_30px_rgba(36,151,232,0.25)]
           hover:scale-105
           active:scale-95
                   "
                    >
                        ←
                    </button>

                    <button
                        type="button"
                        class="business-stack-next flex h-12 w-12 items-center justify-center
                   rounded-full border border-[#D8ECFF]
                   text-[28px] text-[#2497E8]
                  disabled:opacity-40
                                                 transition-all duration-300 ease-out
           hover:border-[#2497E8]
           hover:bg-[#2497E8]
           hover:text-white
           hover:shadow-[0_10px_30px_rgba(36,151,232,0.25)]
           hover:scale-105
           active:scale-95
                   "
                    >
                        →
                    </button>
                </div>
            </div>
        </div>

        <div>
            <h3 x-data="revealOnScroll()" class="mb-2 text-2xl">
                Результаты для заинтересованных сторон
            </h3>

            <p x-data="revealOnScroll()" class="mb-8">
                Ресурсы, используемые в цепочке создания стоимости, сгруппированы в шесть капиталов:
                человеческий, производственный, финансовый, интеллектуальный, социально-репутационный и природный.
            </p>

            <div
                x-data="revealOnScroll()"
                class="business-stack-slider relative"
            >
                <div class="swiper business-stack-swiper business-results-swiper">
                    <div class="swiper-wrapper">
                        @foreach($resultSlides as $slide)
                            <div class="swiper-slide">
                                @if(isset($slide['content']))
                                    {!! $slide['content'] !!}
                                @elseif(isset($slide['imgs']))
                                    <div class="h-[260px] rounded-[16px] bg-[#F1F6FE]
                                   px-8 py-8
                                   shadow-[0_12px_25px_rgba(33,74,104,0.08)]
                                   md:h-auto md:min-h-[500px]">
                                        <h4 class="@if($slide['subtitle'] ?? null) mb-1 @endif text-lg text-blue-900">
                                            {{ $slide['title'] }}
                                        </h4>
                                        @if($slide['subtitle'] ?? null)
                                            <p class="mb-2 text-sm ">
                                                {{ $slide['subtitle'] }}
                                            </p>
                                        @endif
                                        <div class="grid gap-4 {{$slide['class']}}">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <img
                                                    class="{{$slide['img_class'] ?? ''}}"
                                                    src="/fixed/slider-card-2.{{ $slide['slide_number'] }}.{{ $i }}.png"
                                                    alt="">
                                            @endfor
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="h-[260px] rounded-[16px] bg-[#F1F6FE]
                                   px-8 py-8
                                   shadow-[0_12px_25px_rgba(33,74,104,0.08)]
                                   md:h-auto md:min-h-[500px]"
                                    >
                                        <h4 class="mb-5 text-lg text-blue-900">
                                            {{ $slide['title'] }}
                                        </h4>

                                        <div class="grid grid-cols-3 gap-x-8 gap-y-5 lg:grid-cols-2 md:!grid-cols-1">
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
                                                                    <span
                                                                        class="absolute rounded-full bg-white px-2
                                                               text-[10px] text-green-300
                                                               {{ $diff['class'] }}"
                                                                    >
                                                                {{ $diff['value'] }}
                                                            </span>
                                                                @endforeach
                                                            @endif

                                                            <div class="text-3xl text-blue-400">
                                                                {!! $stat['value'] !!}
                                                            </div>

                                                            @if($stat['unit'])
                                                                <div class="mt-1 text-lg text-blue-400">
                                                                    {{ $stat['unit'] }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        @if($stat['text'])
                                                            <p class="mt-1 text-sm leading-[14px]">
                                                                {{ $stat['text'] }}
                                                            </p>
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

                <div class="mt-4 flex justify-center gap-4">
                    <button
                        type="button"
                        class="business-stack-prev flex h-12 w-12 items-center justify-center
                   rounded-full border border-[#D8ECFF]
                   text-[28px] text-[#2497E8]  disabled:opacity-40
                                                 transition-all duration-300 ease-out
           hover:border-[#2497E8]
           hover:bg-[#2497E8]
           hover:text-white
           hover:shadow-[0_10px_30px_rgba(36,151,232,0.25)]
           hover:scale-105
           active:scale-95
                   "
                    >
                        ←
                    </button>

                    <button
                        type="button"
                        class="business-stack-next flex h-12 w-12 items-center justify-center
                   rounded-full border border-[#D8ECFF]
                   text-[28px] text-[#2497E8]  disabled:opacity-40
                              transition-all duration-300 ease-out
           hover:border-[#2497E8]
           hover:bg-[#2497E8]
           hover:text-white
           hover:shadow-[0_10px_30px_rgba(36,151,232,0.25)]
           hover:scale-105
           active:scale-95
                   "
                    >
                        →
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@push('page-js')
    <script type="module">
        document.querySelectorAll('.business-stack-slider').forEach((sliderBlock) => {
            const swiperElement = sliderBlock.querySelector(
                '.business-stack-swiper'
            );

            const prevButton = sliderBlock.querySelector(
                '.business-stack-prev'
            );

            const nextButton = sliderBlock.querySelector(
                '.business-stack-next'
            );

            if (!swiperElement) {
                return;
            }

            const updateCards = (swiperInstance) => {
                const slides = Array.from(swiperInstance.slides);
                const activeIndex = swiperInstance.activeIndex;
                const isMobile = window.innerWidth <= 767;

                slides.forEach((slide, index) => {
                    slide.classList.remove(
                        'is-stack-visible',
                        'is-active-card',
                        'is-stack-depth-1',
                        'is-stack-depth-2'
                    );

                    if (isMobile) {
                        const isActive = index === activeIndex;

                        if (isActive) {
                            slide.classList.add(
                                'is-stack-visible',
                                'is-active-card'
                            );
                        }

                        slide.style.transform = 'translateY(0) scale(1)';
                        slide.style.zIndex = isActive ? '10' : '0';

                        return;
                    }

                    const depth = index - activeIndex;

                    if (depth >= 0 && depth <= 2) {
                        const translateY = depth * 20;
                        const scale = 1 - depth * 0.04;

                        slide.classList.add('is-stack-visible');

                        if (depth === 0) {
                            slide.classList.add('is-active-card');
                        }

                        if (depth === 1) {
                            slide.classList.add('is-stack-depth-1');
                        }

                        if (depth === 2) {
                            slide.classList.add('is-stack-depth-2');
                        }

                        slide.style.transform =
                            `translateY(${translateY}px) scale(${scale})`;

                        slide.style.zIndex = String(10 - depth);
                    } else {
                        slide.style.transform =
                            'translateY(50px) scale(0.9)';

                        slide.style.zIndex = '0';
                    }
                });
            };

            const swiper = new Swiper(swiperElement, {
                slidesPerView: 1,
                speed: 500,
                virtualTranslate: true,
                loop: false,
                allowTouchMove: true,

                navigation: {
                    prevEl: prevButton,
                    nextEl: nextButton,
                },

                on: {
                    init(swiperInstance) {
                        updateCards(swiperInstance);
                    },

                    slideChange(swiperInstance) {
                        updateCards(swiperInstance);
                    },

                    resize(swiperInstance) {
                        updateCards(swiperInstance);
                    },
                },
            });
        });
    </script>
@endpush
