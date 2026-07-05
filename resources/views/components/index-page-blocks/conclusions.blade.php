@php
    $items = [
        [
            'icon' => 'grid',
            'text' => 'Близкие приоритеты обеих групп заинтересованных сторон',
        ],
        [
            'icon' => 'head',
            'text' => 'Первоочередное внимание к основной деятельности Компании',
        ],
        [
            'icon' => 'mail',
            'text' => 'Большая важность повестки Компании для ее внутренних заинтересованных сторон',
        ],
        [
            'icon' => 'people',
            'text' => 'Отсутствие критического воздействия Компании на вопросы экологии и охраны окружающей среды в глазах обеих групп заинтересованных сторон',
        ],
    ];
@endphp

<section class="container py-8 text-[#0B4775]">
    <h2 class="mb-5 text-[34px] uppercase leading-none text-[#0060A8] md:text-[26px]">
        Ключевые выводы
    </h2>

    <div class="grid grid-cols-4 gap-2 lg:grid-cols-2 md:grid-cols-1">
        @foreach($items as $item)
            <div class="flex min-h-[210px] flex-col justify-between rounded-[10px] bg-[#F1F6FE] px-5 py-5">
                <div class="h-[58px]">
                    @switch($item['icon'])
                        @case('grid')
                            <svg width="52" height="52" viewBox="0 0 52 52" fill="none">
                                @foreach([0, 1, 2] as $y)
                                    @foreach([0, 1, 2] as $x)
                                        <rect x="{{ 2 + $x * 18 }}" y="{{ 2 + $y * 18 }}" width="10" height="10" rx="1.5"
                                              stroke="currentColor" stroke-width="4"/>
                                    @endforeach
                                @endforeach
                            </svg>
                            @break

                        @case('head')
                            <svg width="58" height="58" viewBox="0 0 58 58" fill="none">
                                <path d="M31 8C19.5 8 12 16.4 12 27.2c0 5.1 2.1 9.1 5 12v8.3c0 2.2 1.8 4 4 4h11.5c2.2 0 4-1.8 4-4v-2.9h5.1c2.1 0 3.7-1.9 3.3-4l-1.4-7.1 5.2-1.7c1.7-.6 2.3-2.7 1-4L44.4 22C42.7 13.6 37.7 8 31 8Z"
                                      stroke="currentColor" stroke-width="4" stroke-linejoin="round"/>
                                <path d="M31 22v-5M31 36v-5M22 27h5M35 27h5M24.6 20.6l3.5 3.5M33.9 30.9l3.5 3.5M37.4 20.6l-3.5 3.5M28.1 30.9l-3.5 3.5"
                                      stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                                <circle cx="31" cy="27" r="5" stroke="currentColor" stroke-width="4"/>
                            </svg>
                            @break

                        @case('mail')
                            <svg width="58" height="58" viewBox="0 0 58 58" fill="none">
                                <rect x="9" y="17" width="40" height="31" rx="8" stroke="currentColor" stroke-width="4"/>
                                <path d="M11 20l18 16 18-16" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            @break

                        @case('people')
                            <svg width="58" height="58" viewBox="0 0 58 58" fill="none">
                                <circle cx="29" cy="15" r="10" stroke="currentColor" stroke-width="4"/>
                                <circle cx="12" cy="40" r="6" stroke="currentColor" stroke-width="4"/>
                                <circle cx="29" cy="40" r="6" stroke="currentColor" stroke-width="4"/>
                                <circle cx="46" cy="40" r="6" stroke="currentColor" stroke-width="4"/>
                                <path d="M29 25v9M17 37l7-6M41 37l-7-6" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                            </svg>
                            @break
                    @endswitch
                </div>

                <p class="max-w-[230px] text-[14px] leading-[1.35]">
                    {{ $item['text'] }}
                </p>
            </div>
        @endforeach
    </div>
</section>
