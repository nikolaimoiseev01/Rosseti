<section id="contents" class="page-block page-block--content container py-24 md:py-16">
    <h2 x-data="revealOnScroll()" class="mb-4 text-5xl text-blue-900 uppercase leading-none md:text-[26px]">
        Содержание
    </h2>

    <div class="grid grid-cols-4 gap-5 xl:grid-cols-2 md:!grid-cols-1">
        @foreach($pages as $page)
            <a x-data="revealOnScroll()" href="{{route('article.index', $page->slug)}}" wire:navigate class="group flex flex-col overflow-hidden rounded-[28px] bg-white border border-1 border-black-100 transition duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden">
                    <img
                        src="{{ $page->getFirstMediaUrl('cover') }}"
                        class="min-h-60 w-full object-cover transition duration-700 group-hover:scale-110"
                        data-no-lightbox
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <div class="absolute right-4 leading-[100%] top-4 text-[100px] bg-gradient-to-b from-white to-transparent
      bg-clip-text text-transparent">0{{ $loop->index + 1 }}</div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="text-2xl mb-0">{{ $page->title }}</h3>
                    <div class="flex flex-col mt-auto">
{{--                        <p class="text-lg text-black-400">{{ $page->description }}</p>--}}
                        <span class="text-blue-400 inline-block text-lg group-hover:translate-x-1 transition-transform">Подробнее →</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
