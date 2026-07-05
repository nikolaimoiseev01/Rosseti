@php
    $sections = [
        [
            'title' => 'Вклад в национальные цели развития<br>и национальные проекты России',
            'cards' => [
                [
                    'value' => '9,07',
                    'text' => 'уровень удовлетворенности потребителей — участников национальных проектов качеством оказанных Группой компаний «Россети» услуг (индекс CSI)',
                    'class' => 'col-span-1',
                ],
                [
                    'value' => '974',
                    'text' => 'объекта подключено к сетям в рамках реализации национальных проектов России',
                    'class' => 'col-span-1',
                ],
                [
                    'value' => '230 МВА',
                    'text' => 'Трансформаторной мощности построено',
                    'class' => '',
                ],
                [
                    'value' => '170 МВТ',
                    'text' => 'Мощности выделено',
                    'class' => '',
                ],
                [
                    'value' => '400 КМ',
                    'text' => 'ЛЭП построено',
                    'class' => '',
                ],
            ],
        ],
        [
            'title' => 'Персонал и будущие<br>поколения энергетиков',
            'cards' => [
                [
                    'value' => '>3 000',
                    'text' => 'старшеклассников участники проекта «Энергокружки»',
                    'class' => '',
                ],
                [
                    'value' => '>13 000',
                    'text' => 'вузов и ссузов прошли практику в компаниях Группы',
                    'class' => '',
                ],
                [
                    'value' => '>2 800',
                    'text' => 'студентов прошли подготовку по договорам целевого обучения',
                    'class' => '',
                ],
            ],
        ],
    ];
@endphp

<section class="container py-8 text-[#0B4775]">
    @foreach($sections as $section)
        <div class="mb-9 last:mb-0">
            <h2 class="mb-6 text-[34px] uppercase leading-[1.25] text-[#0B4775] md:text-[26px]">
                {!! $section['title'] !!}
            </h2>

            <div class="grid grid-cols-3 gap-1.5 lg:grid-cols-2 md:grid-cols-1">
                @foreach($section['cards'] as $card)
                    <div class="{{ $card['class'] ?? '' }} flex min-h-[130px] flex-col justify-between rounded-[10px] bg-[#F1F6FE] px-5 py-5 lg:col-span-1">
                        <div class="text-[48px] font-light leading-none text-[#2497E8] md:text-[38px]">
                            {{ $card['value'] }}
                        </div>

                        <p class="max-w-[520px] text-[16px] leading-[1.35]">
                            {{ $card['text'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</section>
