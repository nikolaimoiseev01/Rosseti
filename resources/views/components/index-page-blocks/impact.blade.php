@php
    $sections = [
        [
            'title' => __('Вклад в национальные цели развития<br>и национальные проекты России'),
            'cards' => [
                [
                    'value' => '9,07',
                    'text' => __('уровень удовлетворенности потребителей — участников национальных проектов качеством оказанных Группой компаний «Россети» услуг (индекс CSI)'),
                    'class' => 'col-span-3',
                ],
                [
                    'value' => '974',
                    'text' => __('объекта подключено к сетям в рамках реализации национальных проектов России'),
                    'class' => 'col-span-3',
                ],
                [
                    'value' => __('230 МВА'),
                    'text' => __('Трансформаторной мощности построено'),
                    'class' => 'col-span-2',
                ],
                [
                    'value' => __('170 МВТ'),
                    'text' => __('Мощности выделено'),
                    'class' => 'col-span-2',
                ],
                [
                    'value' => __('400 КМ'),
                    'text' => __('ЛЭП построено'),
                    'class' => 'col-span-2',
                ],
            ],
        ],
//        [
//            'title' => __('Персонал и будущие<br>поколения энергетиков'),
//            'cards' => [
//                [
//                    'value' => '>3 000',
//                    'text' => __('старшеклассников участники проекта «Энергокружки»'),
//                    'class' => 'col-span-2',
//                ],
//                [
//                    'value' => '>13 000',
//                    'text' => __('вузов и ссузов прошли практику в компаниях Группы'),
//                    'class' => 'col-span-2',
//                ],
//                [
//                    'value' => '>2 800',
//                    'text' => __('студентов прошли подготовку по договорам целевого обучения'),
//                    'class' => 'col-span-2',
//                ],
//            ],
//        ],
    ];
@endphp

<section x-data="revealOnScroll()" class="page-block page-block--impact container mb-24 text-[#0B4775]">
    @foreach($sections as $section)
        <div class="mb-9 last:mb-0">
            <h2 x-data="revealOnScroll()" class="mb-6 text-5xl uppercase leading-[1.25] text-[#0B4775] md:text-[26px]">
                {!! $section['title'] !!}
            </h2>

            <div class="grid grid-cols-6 gap-1.5 lg:flex-col lg:flex lg:grid-cols-2 md:grid-cols-1">
                @foreach($section['cards'] as $card)
                    <div x-data="revealOnScroll()" class="{{ $card['class'] ?? '' }} flex min-h-[130px] flex-col justify-between rounded-[10px] bg-[#F1F6FE] px-5 py-5 lg:col-span-1">
                        <div class="text-7xl font-light leading-none text-[#2497E8] md:text-[38px]">
                            {{ $card['value'] }}
                        </div>

                        <p class="max-w-[520px] text-2xl md:text-xl leading-[28px]">
                            {{ $card['text'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</section>
