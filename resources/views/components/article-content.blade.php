<style>
    .prose p {
        color: #6B7785;
    }

    .prose img {
        margin: 34px 0;
    }
</style>
<div class="mx-auto flex max-w-7xl pt-10 mb-[180px] gap-8 md:mb-[80px] justify-between">

    <!-- Table of Contents -->
    <aside class="max-w-[263px] lg:hidden">
        <div class="sticky top-20">
            <h3 class="mb-4 text-[28px] uppercase ">Навигация</h3>
            <nav class="space-y-2 mb-10">
                @foreach($page->content as $topic)
                    @if($topic['data']['title'] ?? null)
                        <a href="#{{Str::slug($topic['data']['title'])}}"
                           class="block hover:underline text-black-400 text-nowrap">
                            {{$topic['data']['title']}}
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
    </aside>


    <!-- Main Article -->
    <main class="flex-1 lg:w-full">
        <article class="prose pr-6 space-y-12">
            @foreach($page->content as $block)
                @include('components.page-blocks.' . $block['type'], ['data' => $block['data']])
            @endforeach
        </article>
    </main>

</div>

<script>
    let tocObserver = null;

    function setupTocObserver() {
        if (tocObserver) tocObserver.disconnect();

        const $tocLinks = document.querySelectorAll('aside nav a');

        tocObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;

                    $tocLinks.forEach(link => {
                        const isActive = link.getAttribute('href') === `#${id}`;
                        link.classList.toggle('text-blue-400', isActive);
                    });
                }
            });
        }, {
            rootMargin: '0px 0px -70% 0px',
            threshold: 0
        });

        document.querySelectorAll('main h2[id]').forEach(h2 => {
            tocObserver.observe(h2);
        });
    }

    window.addEventListener('load', setupTocObserver);

    document.addEventListener('livewire:navigated', () => {
        setTimeout(setupTocObserver, 100);
    });
</script>
