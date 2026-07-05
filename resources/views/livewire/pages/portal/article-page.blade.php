<section class="pt-32 flex-1">
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
        {{$page->title}}
    @endsection
    <div x-data="revealOnScroll()" class="flex flex-col mb-14 container md:mb-12 relative py-12 items-center justify-center">
        <img src="{{$page->getFirstMediaUrl('cover')}}"
             class="absolute z-10  h-full transition-all duration-700 ease-out w-full rounded-2xl max-h-[642px] object-cover md:aspect-square" alt="">
        <span class="relative z-20 text-5xl bg-gradient-to-b from-white to-transparent
      bg-clip-text text-transparent">0{{$page->sort + 1}}</span>
        <h1 class="relative z-20 text-white">{{$page->title}}</h1>

    </div>
    <x-article-content :page="$page"/>

</section>
