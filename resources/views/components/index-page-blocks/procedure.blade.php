@php
    $blockBgClasses = [
        'blue' => 'bg-blue-400 text-white',
        'grey' => 'bg-black-600 text-[#4A4A4A]',
        'white' => 'bg-white text-[#4A4A4A]',
        'green' => 'bg-green-50 text-[#4A4A4A]',
    ];

    $arrowBgClasses = [
        'white' => 'bg-white',
        'grey' => 'bg-black-600',
        'green' => 'bg-green-50',
        'blue' => 'bg-blue-400',
    ];

    $rowClasses = [
        'top' => 'h-[100px]',
        'center' => 'h-[136px]',
        'bottom' => 'h-[100px]',
    ];

    $arrowPositionClasses = [
        'top' => 'top-[-14px] left-1/2 -translate-x-1/2',
        'right' => 'right-[-14px] top-1/2 -translate-y-1/2',
        'bottom' => 'bottom-[-20px] left-1/2 -translate-x-1/2',
        'left' => 'left-[-14px] top-1/2 -translate-y-1/2',
    ];

    $arrowRotateClasses = [
        'top' => '-rotate-90',
        'right' => 'rotate-0',
        'bottom' => 'rotate-90',
        'left' => 'rotate-180',
    ];

    $columns = [
        [
            'blocks' => [
                [
                    'row' => 'top',
                    'bg' => 'blue',
                    'text' => 'Внутренняя группа по вопросам<br>устойчивого развития',
                    'arrows' => [
                        [
                            'position' => 'bottom',
                            'bg' => 'grey',
                        ],
                    ],
                ],
                [
                    'row' => 'center',
                    'bg' => 'grey',
                    'text' => 'Анализ контекста<br>и трендов',
                    'arrows' => [
                        [
                            'position' => 'right',
                            'bg' => 'white',
                        ],
                    ],
                ],
            ],
        ],
        [
            'blocks' => [
                [
                    'row' => 'center',
                    'bg' => 'grey',
                    'text' => 'Формирование списка потенциально существенных тем на основе обзора отраслевых практик, рекомендаций, национальных и международных стандартов',
                    'arrows' => [
                        [
                            'position' => 'right',
                            'bg' => 'white',
                        ],
                    ],
                ],
            ],
        ],
        [
            'blocks' => [
                [
                    'row' => 'top',
                    'bg' => 'blue',
                    'text' => 'Внутренние<br>Заинтересованные стороны',
                    'arrows' => [
                        [
                            'position' => 'bottom',
                            'bg' => 'white',
                        ],
                    ],
                ],
                [
                    'row' => 'center',
                    'bg' => 'grey',
                    'text' => 'Анкетирование<br>респондентов',
                    'arrows' => [
                        [
                            'position' => 'right',
                            'bg' => 'white',
                        ],
                    ],
                ],
                [
                    'row' => 'bottom',
                    'bg' => 'blue',
                    'text' => 'Внешние<br>Заинтересованные стороны',
                    'arrows' => [
                        [
                            'position' => 'top',
                            'bg' => 'white',
                        ],
                    ],
                ],
            ],
        ],
        [
            'blocks' => [
                [
                    'row' => 'center',
                    'bg' => 'grey',
                    'text' => 'Анализ результатов анкетирования, приоритизация<br>и утверждение существенных тем',
                    'arrows' => [
                        [
                            'position' => 'right',
                            'bg' => 'white',
                        ],
                    ],
                ],
            ],
        ],
        [
            'blocks' => [
                [
                    'row' => 'center',
                    'bg' => 'grey',
                    'text' => 'Раскрытие информации<br>в Отчете',
                ],
            ],
        ],
    ];

    $rows = ['top', 'center', 'bottom'];
@endphp

<section class="page-block page-block--procedure container mb-16 text-[#4A4A4A]">
    <h3
        x-data="revealOnScroll()"
        class="mb-6 text-center text-[24px] leading-snug text-blue-500 md:text-left md:text-[16px]"
    >
        Процедура выявления существенных тем и определение существенности воздействия:
    </h3>

    <div
        x-data="revealOnScroll()"
        class="grid grid-cols-[1fr_1.7fr_1fr_1.15fr_0.9fr] gap-x-2 lg:grid-cols-1 lg:gap-3"
    >
        @foreach($columns as $column)
            <div class="grid grid-rows-[100px_136px_68px] gap-y-2 lg:flex lg:flex-col">
                @foreach($rows as $row)
                    @php
                        $block = collect($column['blocks'])->firstWhere('row', $row);
                    @endphp

                    <div class="{{ $rowClasses[$row] }} relative lg:h-auto">
                        @if($block)
                            <div
                                class="{{ $blockBgClasses[$block['bg'] ?? 'grey'] }}
                                    {{ $block['class'] ?? '' }}
                                    relative flex h-full items-center justify-center rounded-[10px]
                                    px-5 py-3 text-center text-[18px] leading-[1.25] lg:min-h-[90px]"
                            >
                                {!! $block['text'] !!}

                                @foreach($block['arrows'] ?? [] as $arrow)
                                    @php
                                        $position = $arrow['position'] ?? 'right';
                                        $arrowBg = $arrow['bg'] ?? 'white';
                                        $arrowColor = $arrow['color'] ?? '#2196F3';
                                    @endphp

                                    <div
                                        class="{{ $arrowPositionClasses[$position] }}
                                            {{ $arrowBgClasses[$arrowBg] }}
                                            absolute z-10 rounded-full p-2 lg:hidden"
                                    >
                                        <svg
                                            class="{{ $arrowRotateClasses[$position] }}"
                                            width="12"
                                            height="12"
                                            viewBox="0 0 12 12"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M1.03605 11.2343C0.935964 11.3344 0.800218 11.3906 0.658676 11.3906C0.517134 11.3906 0.381391 11.3344 0.281307 11.2343C0.181223 11.1341 0.124998 10.9983 0.125 10.8568C0.125002 10.7152 0.181231 10.5794 0.281318 10.4793L5.06283 5.69619L0.281318 0.913108C0.181231 0.812991 0.125002 0.677203 0.125 0.535615C0.124997 0.394027 0.181223 0.258237 0.281306 0.158117C0.38139 0.0579977 0.517134 0.00175093 0.658676 0.00174902C0.800218 0.00174615 0.935963 0.0579891 1.03605 0.158106L6.19494 5.31868C6.2445 5.36826 6.28381 5.42711 6.31063 5.49188C6.33746 5.55665 6.35126 5.62608 6.35126 5.69619C6.35126 5.76629 6.33746 5.83572 6.31063 5.90049C6.28381 5.96526 6.2445 6.02411 6.19494 6.07369L1.03605 11.2343ZM5.19247 0.913108L9.97398 5.69619L5.19247 10.4793C5.09238 10.5794 5.03615 10.7152 5.03615 10.8568C5.03615 10.9983 5.09237 11.1341 5.19246 11.2343C5.29254 11.3344 5.42829 11.3906 5.56983 11.3906C5.71137 11.3906 5.84712 11.3344 5.9472 11.2343L11.1061 6.07369C11.1556 6.02411 11.195 5.96526 11.2218 5.90049C11.2486 5.83572 11.2624 5.76629 11.2624 5.69619C11.2624 5.62608 11.2486 5.55665 11.2218 5.49188C11.195 5.42711 11.1556 5.36826 11.1061 5.31868L5.9472 0.158106C5.84711 0.0579889 5.71137 0.00174593 5.56983 0.0017488C5.42829 0.00175071 5.29254 0.0579975 5.19246 0.158117C5.09237 0.258237 5.03615 0.394027 5.03615 0.535615C5.03615 0.677203 5.09238 0.812991 5.19247 0.913108Z"
                                                fill="{{ $arrowColor }}"
                                            />
                                        </svg>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
