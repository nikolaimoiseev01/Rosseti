<style>
    .prose p {
        color: #6B7785;
    }

    .prose img {
        margin: 34px 0;
    }
</style>
<div class="container mx-auto flex max-w-7xl pt-10 mb-[180px] gap-8 md:mb-[80px] justify-between">

    <!-- Table of Contents (Desktop Sidebar) -->
    <aside class="max-w-[263px] flex lg:hidden">
        <div class="sticky top-20">
            <h3 class="mb-4 text-[28px] uppercase ">Навигация</h3>
            <nav class="space-y-2 mb-10 text-lg" id="toc-nav">
                <!-- TOC will be populated by JavaScript -->
            </nav>
        </div>
    </aside>


    <!-- Main Article -->
    <main class="flex-1 lg:w-full">
        <!-- Horizontal Navigation (Mobile/Tablet) -->
        <div class="hidden lg:flex sticky top-16 z-30 bg-white border rounded-[10px] border-black-100 py-3 px-2 mb-6">
            <nav class="flex gap-4 overflow-x-auto scrollbar-hide" id="toc-nav-horizontal">
                <!-- TOC will be populated by JavaScript -->
            </nav>
        </div>

        <article class="prose pr-6">
            @foreach($page->blocks as $block)
                @php
                    $data = !empty($block->data_languages) ? $block->data_languages : $block->data;
                    $currentLang = session('locale', 'ru');
                @endphp

                @if(!empty($data['ru']) && !empty($data['en']))
                    @php
                        $localizedData = array_merge($data[$currentLang], $data);
                        unset($localizedData['ru'], $localizedData['en']);
                    @endphp
                    @include('components.page-blocks.' . $block->type, ['data' => $localizedData])
                @else
                    @php
                        if (isset($data[$currentLang])) {
                            $localizedData = array_merge($data[$currentLang], $data);
                            unset($localizedData['ru'], $localizedData['en']);
                        } else {
                            $localizedData = $data;
                        }
                    @endphp
                    @include('components.page-blocks.' . $block->type, ['data' => $localizedData])
                @endif
            @endforeach
        </article>
    </main>

</div>

<script>
    var tocObserver = null;

    function buildToc() {
        const $tocNav = document.getElementById('toc-nav');
        const $tocNavHorizontal = document.getElementById('toc-nav-horizontal');
        if (!$tocNav && !$tocNavHorizontal) return;

        const $headings = document.querySelectorAll('main article h1');

        if ($tocNav) {
            $tocNav.innerHTML = '';
        }
        if ($tocNavHorizontal) {
            $tocNavHorizontal.innerHTML = '';
        }

        $headings.forEach((heading, index) => {
            if (!heading.id) {
                const text = heading.textContent.trim();
                heading.id = 'heading-' + index + '-' + text.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '');
            }

            // Desktop sidebar navigation
            if ($tocNav) {
                const link = document.createElement('a');
                link.href = '#' + heading.id;
                link.textContent = heading.textContent.trim();
                link.className = 'block hover:underline text-black-400 leading-snug';
                $tocNav.appendChild(link);
            }

            // Horizontal navigation (mobile/tablet)
            if ($tocNavHorizontal) {
                const link = document.createElement('a');
                link.href = '#' + heading.id;
                link.textContent = heading.textContent.trim();
                link.className = 'whitespace-nowrap text-lg text-black-400 hover:text-blue-500 transition-colors';
                $tocNavHorizontal.appendChild(link);
            }
        });
    }

    function setupTocObserver() {
        if (tocObserver) tocObserver.disconnect();

        const $tocLinks = document.querySelectorAll('#toc-nav a');
        const $tocLinksHorizontal = document.querySelectorAll('#toc-nav-horizontal a');
        const $tocNavHorizontal = document.getElementById('toc-nav-horizontal');

        tocObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;

                    // Update desktop navigation
                    $tocLinks.forEach(link => {
                        const isActive = link.getAttribute('href') === `#${id}`;
                        link.classList.toggle('text-blue-400', isActive);
                    });

                    // Update horizontal navigation
                    $tocLinksHorizontal.forEach(link => {
                        const isActive = link.getAttribute('href') === `#${id}`;
                        link.classList.toggle('text-blue-500', isActive);
                        link.classList.toggle('text-black-400', !isActive);

                        // Scroll to active link smoothly
                        if (isActive && $tocNavHorizontal) {
                            const navRect = $tocNavHorizontal.getBoundingClientRect();
                            const linkRect = link.getBoundingClientRect();
                            const scrollLeft = $tocNavHorizontal.scrollLeft;

                            // Calculate position to scroll link to left edge
                            const targetScrollLeft = scrollLeft + (linkRect.left - navRect.left);

                            $tocNavHorizontal.scrollTo({
                                left: targetScrollLeft,
                                behavior: 'smooth'
                            });
                        }
                    });
                }
            });
        }, {
            rootMargin: '0px 0px -70% 0px',
            threshold: 0
        });

        document.querySelectorAll('main article h1[id]').forEach(heading => {
            tocObserver.observe(heading);
        });
    }

    window.addEventListener('load', () => {
        buildToc();
        setupTocObserver();
    });

    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => {
            buildToc();
            setupTocObserver();
        }, 100);
    });
</script>
