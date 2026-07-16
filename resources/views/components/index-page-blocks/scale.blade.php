<section class="page-block page-block--scale container py-12">
    <div class="relative overflow-hidden rounded-[32px] min-h-[767px]">
        {{-- Background image --}}
        <img
            src="/fixed/change-topics-bg.jpg"
            alt=""
            class="absolute inset-0 h-full w-full object-cover"
            data-no-lightbox
        >
        {{-- Dark overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r bg-black-900/10"></div>

        <div class="relative z-10 flex flex-col justify-between h-full p-12 lg:p-8 sm:p-6 min-h-[767px]">
            {{-- Title --}}
            <h2 x-data="revealOnScroll()" class="text-[72px] text-white font-light uppercase leading-none md:text-[32px] lg:mb-16">
                Масштаб Группы компаний «Россети»
            </h2>

            {{-- Stats layout --}}
            <div x-data="revealOnScroll()" class="flex items-end justify-between gap-12 lg:flex-col lg:items-start mt-auto">
                {{-- Left: vertical stats --}}
                <div class="flex flex-col gap-8">
                    <div>
                        <div class="text-white text-7xl font-light md:text-5xl">82</div>
                        <p class="text-white/80 text-2xl mt-1">региона присутствия</p>
                    </div>
                    <div>
                        <div class="text-white text-7xl font-light md:text-5xl">69</div>
                        <p class="text-white/80 text-2xl mt-1">регионов имеют статус СТСО</p>
                    </div>
                    <div>
                        <div class="text-white text-7xl font-light md:text-5xl">122</div>
                        <p class="text-white/80 text-2xl mt-1 max-w-[280px]">межгосударственные линии электропередачи, по которым осуществляется учет перетоков электроэнергии</p>
                    </div>
                </div>

                {{-- Right: large percentage --}}
                <div class="text-right lg:text-left">
                    <div class="text-white text-[320px] font-normal leading-[200px] lg:text-[100px] md:!text-[80px] md:!leading-[60px]">~80%</div>
                    <p class="text-white/80 text-2xl max-w-[350px] ml-auto lg:ml-0">вырабатываемой электроэнергии<br> передается по сетям Группы</p>
                </div>
            </div>
        </div>
    </div>
</section>
