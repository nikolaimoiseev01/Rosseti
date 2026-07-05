<section id="contents" class="container py-24 md:py-16">
    <h2 class="mb-12 text-[52px] font-semibold leading-none md:text-[36px]">
        Содержание
    </h2>

    @php
        $contents = [
            ['num' => '01', 'title' => 'О компании', 'text' => 'Ключевая роль в обеспечении надежного электроснабжения страны.', 'img' => '/images/content-01.jpg', 'slug' => 'about-company'],
            ['num' => '02', 'title' => 'Управление устойчивым развитием', 'text' => 'Последовательное развитие устойчивого управления.', 'img' => '/images/content-02.jpg', 'slug' => 'sustainability'],
            ['num' => '03', 'title' => 'Вклад в развитие страны', 'text' => 'Инвестиции и вклад в экономику регионов.', 'img' => '/images/content-03.jpg', 'slug' => 'contribution'],
            ['num' => '04', 'title' => 'Забота об окружающей среде', 'text' => 'Снижение экологического воздействия.', 'img' => '/images/content-04.jpg', 'slug' => 'environment'],
            ['num' => '05', 'title' => 'Защита прав человека', 'text' => 'Сильная команда и ответственность работодателя.', 'img' => '/images/content-05.png', 'slug' => 'human-rights'],
            ['num' => '06', 'title' => 'Вклад в общество', 'text' => 'Поддержка регионов и социальных инициатив.', 'img' => '/images/content-06.jpg', 'slug' => 'society'],
            ['num' => '07', 'title' => 'Управленческий аспект', 'text' => 'Финансовая устойчивость и корпоративное управление.', 'img' => '/images/content-07.jpg', 'slug' => 'governance'],
            ['num' => '08', 'title' => 'Приложения', 'text' => 'Прозрачная отчетность по международным стандартам.', 'img' => '/images/content-08.jpg', 'slug' => 'appendix'],
        ];
    @endphp

    <div class="grid grid-cols-4 gap-5 xl:grid-cols-3 lg:grid-cols-2 sm:grid-cols-1">
        @foreach($contents as $card)
            <a href="" class="group overflow-hidden rounded-[28px] bg-white shadow-sm transition duration-300 hover:-translate-y-1">
                <div class="relative h-48 overflow-hidden">
                    <img
                        src="{{ $card['img'] }}"
                        alt="{{ $card['title'] }}"
                        class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <div class="absolute left-5 top-5 text-5xl font-semibold text-white">{{ $card['num'] }}</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-blue-500">{{ $card['title'] }}</h3>
                    <p class="mt-3 text-sm text-black-400">{{ $card['text'] }}</p>
                    <span class="mt-6 inline-block text-sm font-semibold text-[#009FE3] group-hover:translate-x-1 transition-transform">Подробнее →</span>
                </div>
            </a>
        @endforeach
    </div>
</section>
