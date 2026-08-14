<section class="pt-32 flex-1 md:pt-22">
    <style>
        .article-content p {
            max-width: 648px;
            margin: auto;
        }

        .article-content img {
            margin: auto;
        }

        .attachment__caption {
            display: none;
        }
    </style>
    @section('title')
        @php
            $currentLang = session('locale', 'ru');
            $pageTitle = !empty($page->title_languages) && isset($page->title_languages[$currentLang])
                ? $page->title_languages[$currentLang]
                : $page->title;
        @endphp
        {{$pageTitle}}
    @endsection
    @php
        $coverHeight = $page->cover_height ?? '216px';
        $maxHeightClass = $coverHeight === 'full' ? 'h-full' : 'min-h-[' . $coverHeight . '] max-h-[' . $coverHeight . ']';
    @endphp
    @if($page->cover_height === 'custom')
        <img x-data="revealOnScroll()" src="{{$page->getFirstMediaUrl('cover')}}"
             class="container lg:hidden z-10 h-full transition-all duration-700 ease-out w-full rounded-2xl  object-cover md:aspect-square"
             alt="">
        @if($page->getFirstMediaUrl('cover_mobile'))
            <img x-data="revealOnScroll()" src="{{$page->getFirstMediaUrl('cover_mobile')}}"
                 class="container lg:block hidden z-10 h-full transition-all duration-700 ease-out w-full rounded-2xl  object-cover md:aspect-square"
                 alt="">
        @endif
    @else
        <div x-data="revealOnScroll()" style="height: {{ $coverHeight }}"
             class="flex flex-col mb-14 container md:mb-12 relative py-12 px-2 text-center items-center justify-center lg:mb-6">
            <img src="{{$page->getFirstMediaUrl('cover')}}"
                 class="absolute z-10 h-full transition-all duration-700 ease-out w-full rounded-2xl {{ $maxHeightClass }} object-cover md:aspect-square"
                 alt="">
            <span class="relative z-20 text-5xl bg-gradient-to-b from-white to-transparent
      bg-clip-text text-transparent">0{{$page->sort + 1}}</span>
            <h1 class="relative z-20 text-white">
                @php
                    $titlePage = !empty($page->title_page_languages) && isset($page->title_page_languages[$currentLang])
                        ? $page->title_page_languages[$currentLang]
                        : $page->title_page;
                @endphp
                {{$titlePage}}
            </h1>
        </div>
    @endif
    <x-article-content :page="$page"/>

    <!-- Navigation Buttons -->
    <div class="container mx-auto max-w-7xl flex flex-col items-center py-8 gap-4">
        @php
            $previousPage = \App\Models\Page::where('sort', '<', $page->sort)->orderBy('sort', 'desc')->first();
            $nextPage = \App\Models\Page::where('sort', '>', $page->sort)->orderBy('sort', 'asc')->first();
        @endphp

        @if($nextPage)
            <a href="{{ route('article.index', $nextPage->slug) }}" wire:navigate
               class="flex w-full bg-blue-400 items-center gap-2 justify-center px-6 py-3 rounded-lg shadow hover:shadow-md transition-shadow">
                <span class="text-lg text-white font-medium">Следующий раздел</span>
            </a>
        @else
            <div></div>
        @endif

        @if($previousPage)
            <a href="{{ route('article.index', $previousPage->slug) }}" wire:navigate
               class="w-full flex justify-center items-center text-center gap-2 px-6 py-3 text-white text-lg rounded-lg">
                <span class="text-lg font-medium">Предыдущий раздел</span>
            </a>
        @else
            <div></div>
        @endif
    </div>

</section>
