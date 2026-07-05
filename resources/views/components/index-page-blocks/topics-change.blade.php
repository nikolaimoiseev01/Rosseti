@php
    $buttons = [
        'Забота о потребителях',
        'Цифровые технологии',
    ];
@endphp

<section class="container py-8">
    <div
        class="relative overflow-hidden rounded-[22px] bg-cover bg-center px-10 py-11 text-white md:px-5 md:py-8"
        style="background-image: url('/fixed/change-topics-bg.jpg');"
    >
        <div class="relative z-10">
            <h2 class="mb-5 text-[56px] font-light uppercase leading-none md:text-[32px]">
                Изменения существенных тем
            </h2>

            <div class="grid grid-cols-[280px_1fr] gap-12 md:grid-cols-1 md:gap-5">
                <p class="text-[17px] leading-[1.35] md:text-[15px]">
                    В отчетном году сохранен ранее применяемый методологический подход,
                    уточнен перечень существенных тем.
                </p>

                <div>
                    <p class="mb-5 max-w-[660px] text-[17px] leading-[1.35] md:text-[15px]">
                        Анализ стратегических приоритетов Группы «Россети» в условиях цифровой
                        трансформации, возросшие требования к скорости, прозрачности и цифровой
                        доступности услуг выявили необходимость выделения двух существенных тем,
                        оказывающих значимое воздействие на устойчивость и надежность электросетевого комплекса.
                    </p>

                    <div class="flex gap-3 md:flex-col">
                        @foreach($buttons as $button)
                            <div class="min-w-[210px] rounded-[6px] bg-[#2497E8] px-6 py-4 text-center text-[14px] leading-none text-white md:min-w-0">
                                {{ $button }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
