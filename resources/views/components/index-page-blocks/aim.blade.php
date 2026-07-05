@php
    $goals = [
        'Создание единого электросетевого комплекса Российской Федерации путем консолидации электросетевых активов под управлением Группы компаний «Россети»',
        'Повышение эффективности функционирования электросетевого комплекса',
        'Обеспечение реализации национальных проектов Российской Федерации',
        'Обеспечение надежности и доступности электроснабжения',
        'Обеспечение технологического суверенитета',
    ];
@endphp

<section class="container py-8 text-[#0B4775]">
    <div
        class="mb-2 overflow-hidden rounded-[10px] bg-cover bg-center px-10 py-10 text-white md:px-5 md:py-7"
        style="background-image: url('/fixed/aim-bg.jpg');"
    >
        <h2 class="mb-7 max-w-[760px] text-[58px] font-light uppercase leading-[1.08] md:text-[34px]">
            Ключевая цель в области устойчивого развития
        </h2>

        <p class="max-w-[620px] text-[18px] font-semibold leading-[1.35] md:text-[15px]">
            Группа компаний «Россети» стремится максимально содействовать достижению Целей устойчивого развития ООН
            в рамках своей операционной деятельности, а также формировать дополнительную ценность для всех
            заинтересованных сторон в контексте национальных и глобальных задач.
        </p>
    </div>

    <div class="grid grid-cols-2 gap-2 lg:grid-cols-1">
        <div class="rounded-[10px] bg-[#F1F6FE] px-10 py-8 md:px-5">
            <h3 class="mb-5 text-[20px] font-normal text-[#0B4775]">
                Наша миссия
            </h3>

            <div class="space-y-5 text-[14px] leading-[1.6] text-[#4A4A4A]">
                <p>
                    Доступная и качественная электроэнергия в каждый дом, учреждение и производство
                    для комфортной жизни людей, ведения бизнеса и развития экономики страны.
                </p>

                <p>
                    Обеспечение надежного и доступного электроснабжения — ключевой элемент социальной
                    ответственности Группы компаний «Россети», способствующий повышению благополучия граждан,
                    развитию социально-экономического потенциала и укреплению единства страны.
                </p>
            </div>
        </div>

        <div class="rounded-[10px] bg-[#F1F6FE] px-10 py-8 md:px-5">
            <h3 class="mb-5 text-[20px] font-normal text-[#0B4775]">
                Наши стратегические цели
            </h3>

            <div class="grid grid-cols-2 gap-x-8 gap-y-6 text-[14px] leading-[1.45] text-[#4A4A4A] md:grid-cols-1">
                @foreach($goals as $goal)
                    <div class="flex gap-3">
                        <span class="mt-1 flex h-[16px] w-[16px] shrink-0 items-center justify-center rounded-full bg-[#2497E8] text-[10px] text-white">
                            ✓
                        </span>

                        <p>{{ $goal }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
