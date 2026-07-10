@php
    $buttons = [
        'Забота о потребителях',
        'Цифровые технологии',
    ];
@endphp

<section class="container py-8">
    <div
        class="relative min-h-[427px] overflow-hidden rounded-[22px] bg-cover bg-center px-10 py-11 text-white md:px-5 md:py-8"
        style="background-image: url('/fixed/change-topics-bg.jpg');"
    >
        <div class="relative z-10">
            <h2 class="mb-5 text-[72px] text-white font-light uppercase leading-none md:text-[32px]">
                Изменения существенных тем
            </h2>

            <div class="grid grid-cols-[480px_1fr] gap-12 md:grid-cols-1 md:gap-5">
                <p x-data="revealOnScroll()" class="text-2xl md:text-xl leading-7 text-white">
                    В отчетном году сохранен ранее применяемый методологический подход,
                    уточнен перечень существенных тем.
                </p>

                <div>
                    <p x-data="revealOnScroll()" class="mb-5 max-w-[660px] text-2xl md:text-xl leading-7 text-white">
                        Анализ стратегических приоритетов Группы «Россети» в условиях цифровой
                        трансформации, возросшие требования к скорости, прозрачности и цифровой
                        доступности услуг выявили необходимость выделения двух существенных тем,
                        оказывающих значимое воздействие на устойчивость и надежность электросетевого комплекса.
                    </p>

                    <div x-data="revealOnScroll()" class="flex gap-3 md:flex-col">
                        @foreach($buttons as $button)
                            <div class="min-w-[210px] rounded-[6px] bg-[#2497E8] px-6 py-4 text-center text-lg leading-none text-white md:min-w-0">
                                {{ $button }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
