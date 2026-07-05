@php
    $capitalSlides = [
        [
            'title' => 'Производственный (активы)',
            'subtitle' => 'Развитие и реновация инфраструктуры',
            'image' => '/images/business-model-bg.jpg',
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
                ['value' => '837', 'unit' => 'млрд кВт•ч', 'text' => 'объем переданной электроэнергии'],
                ['value' => '14,7', 'unit' => 'ГВт', 'text' => 'объем присоединенной мощности'],
                ['value' => '2,4 SAIDI<br>1,2 SAIFI', 'unit' => '', 'text' => ''],
                ['value' => '35', 'unit' => 'тыс. км', 'text' => 'увеличение протяженности ЛЭП'],
                ['value' => '15', 'unit' => 'тыс. МВА', 'text' => 'ввод новых мощностей подстанций'],
                ['value' => '2 880', 'unit' => 'МВт•ч I-ens', 'text' => ''],
            ],
        ],
    ];
@endphp

<section class="container py-10 text-[#0B4775]">
    <h2 class="mb-4 text-[34px] uppercase leading-none md:text-[26px]">
        Бизнес-модель
    </h2>

    <p class="mb-6 max-w-[520px] text-[14px] leading-[1.5] text-[#4A4A4A]">
        Оказание услуг по передаче электроэнергии, технологическому присоединению потребителей,
        строительству и реконструкции электросетевых объектов — основные виды экономической деятельности Компании.
    </p>

    <div class="grid grid-cols-2 gap-8 lg:grid-cols-1">
        <div>
            <h3 class="mb-2 text-[18px] font-semibold text-[#0060A8]">
                Капиталы (ресурсы)
            </h3>

            <p class="mb-8 text-[14px] leading-[1.5] text-[#4A4A4A]">
                Ресурсы, используемые в цепочке создания стоимости, сгруппированы в шесть капиталов:
                человеческий, производственный, финансовый, интеллектуальный, социально-репутационный и природный.
            </p>

            <div class="swiper business-capitals-swiper">
                <div class="swiper-wrapper">
                    @foreach($capitalSlides as $slide)
                        <div class="swiper-slide pb-10">
                            <div
                                class="relative min-h-[230px] overflow-hidden rounded-[10px] bg-cover bg-center px-7 py-6 text-white shadow-[18px_26px_22px_rgba(0,96,168,.28)]"
                                style="background-image: linear-gradient(90deg, rgba(0,45,25,.55), rgba(0,45,25,.1)), url('{{ $slide['image'] }}');"
                            >
                                <h4 class="mb-1 text-[15px] font-semibold">
                                    {{ $slide['title'] }}
                                </h4>

                                <p class="text-[14px]">
                                    {{ $slide['subtitle'] }}
                                </p>

                                <div class="absolute bottom-7 left-7 right-7 grid grid-cols-2 gap-8">
                                    @foreach($slide['stats'] as $stat)
                                        <div>
                                            <div class="flex items-end gap-2">
                                                <span class="text-[52px] font-light leading-none">
                                                    {{ $stat['value'] }}
                                                </span>
                                                <span class="mb-1 text-[13px] font-semibold">
                                                    {{ $stat['unit'] }}
                                                </span>
                                            </div>

                                            <p class="text-[13px]">
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
            <h3 class="mb-2 text-[18px] font-semibold text-[#0060A8]">
                Результаты для заинтересованных сторон
            </h3>

            <p class="mb-8 text-[14px] leading-[1.5] text-[#4A4A4A]">
                Ресурсы, используемые в цепочке создания стоимости, сгруппированы в шесть капиталов:
                человеческий, производственный, финансовый, интеллектуальный, социально-репутационный и природный.
            </p>

            <div class="swiper business-results-swiper">
                <div class="swiper-wrapper">
                    @foreach($resultSlides as $slide)
                        <div class="swiper-slide pb-10">
                            <div
                                class="min-h-[230px] rounded-[10px] bg-[#F1F6FE] px-7 py-7 shadow-[18px_26px_22px_rgba(11,71,117,.10)]">
                                <h4 class="mb-6 text-[15px] font-semibold">
                                    {{ $slide['title'] }}
                                </h4>

                                <div class="grid grid-cols-3 gap-x-8 gap-y-5 md:grid-cols-2 sm:grid-cols-1">
                                    @foreach($slide['stats'] as $stat)
                                        <div>
                                            <div class="text-[28px] font-light leading-none text-[#2497E8]">
                                                {!! $stat['value'] !!}
                                            </div>

                                            @if($stat['unit'])
                                                <div class="mt-1 text-[13px] font-semibold text-[#2497E8]">
                                                    {{ $stat['unit'] }}
                                                </div>
                                            @endif

                                            @if($stat['text'])
                                                <p class="mt-1 text-[11px] leading-[1.25] text-[#4A4A4A]">
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
