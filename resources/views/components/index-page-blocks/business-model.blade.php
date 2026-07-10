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
    ];
@endphp

<section class="container py-10 ">
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

            <div x-data="revealOnScroll()" class="swiper business-capitals-swiper">
                <div class="swiper-wrapper">
                    @foreach($capitalSlides as $slide)
                        <div class="swiper-slide h-64 min-h-64 lg:h-auto">
                            <div
                                class="relative min-h-64 overflow-hidden lg:flex-col lg:flex rounded-[10px] bg-inherit bg-center px-7 py-6 text-white"
                                style="background-image: url('{{ $slide['image'] }}');"
                            >
                                <div class="absolute inset-0 bg-black-900/10 w-full h-full"></div>
                                <p class="mb-1 text-white">
                                    {{ $slide['title'] }}
                                </p>

                                <p class="text-white">
                                    {{ $slide['subtitle'] }}
                                </p>

                                <div class="absolute lg:relative lg:bottom-auto lg:left-auto bottom-7 left-7 right-7 lg:mt-8 lg:right-auto grid grid-cols-2 md:grid-cols-1 gap-8">
                                    @foreach($slide['stats'] as $stat)
                                        <div>
                                            <div class="flex items-end gap-2 relative">
                                                <span class="text-7xl leading-[50px] text-white leading-none">
                                                    {{ $stat['value'] }}
                                                </span>
                                                <span class="text-white">
                                                    {{ $stat['unit'] }}
                                                </span>
                                            </div>

                                            <p class=" text-white">
                                                {{ $stat['text'] }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3 flex justify-center gap-4">
                    <button
                        class="business-capitals-prev flex h-12 w-12 items-center justify-center rounded-full border border-[#D8ECFF] text-[28px] text-[#2497E8]">
                        ←
                    </button>
                    <button
                        class="business-capitals-next flex h-12 w-12 items-center justify-center rounded-full border border-[#D8ECFF] text-[28px] text-[#2497E8]">
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

            <div x-data="revealOnScroll()" class="swiper business-results-swiper">
                <div class="swiper-wrapper">
                    @foreach($resultSlides as $slide)
                        <div class="swiper-slide max-h-64 lg:max-h-fit">
                            <div
                                class="min-h-[230px] rounded-[10px] bg-[#F1F6FE] px-7 py-7">
                                <h4 class="mb-5 text-lg text-blue-900">
                                    {{ $slide['title'] }}
                                </h4>

                                <div class="grid grid-cols-3 gap-x-8 gap-y-4 lg:grid-cols-2 md:!grid-cols-1">
                                    @foreach($slide['stats'] as $stat)
                                        <div>
                                            <div class="flex gap-2 items-baseline relative">
                                                @if($stat['diff'] ?? null)
                                                    @foreach($stat['diff'] as $diff)
                                                        <span class="bg-white px-2 text-[10px] rounded-full {{$diff['class']}} absolute text-green-300">
                                                        {{$diff['value']}}
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
                                                <p class="text-sm leading-[14px]">
                                                    {{ $stat['text'] }}
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3 flex justify-center gap-4">
                    <button
                        class="business-results-prev flex h-12 w-12 items-center justify-center rounded-full border border-[#D8ECFF] text-[28px] text-[#2497E8]">
                        ←
                    </button>
                    <button
                        class="business-results-next flex h-12 w-12 items-center justify-center rounded-full border border-[#D8ECFF] text-[28px] text-[#2497E8]">
                        →
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')

    <script>
        new Swiper('.business-capitals-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            navigation: {
                prevEl: '.business-capitals-prev',
                nextEl: '.business-capitals-next',
            },
        });

        new Swiper('.business-results-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            navigation: {
                prevEl: '.business-results-prev',
                nextEl: '.business-results-next',
            },
        });
    </script>
@endpush
