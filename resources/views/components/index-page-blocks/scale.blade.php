<section class="container py-12">
    <div class="relative overflow-hidden rounded-[32px] min-h-[500px]">
        {{-- Background image --}}
        <img
            src="/images/mountains-panorama.jpg"
            alt=""
            class="absolute inset-0 h-full w-full object-cover"
        >
        {{-- Dark overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#163B5C]/85 via-[#163B5C]/60 to-[#163B5C]/40"></div>

        <div class="relative z-10 flex flex-col justify-between h-full p-12 lg:p-8 sm:p-6">
            {{-- Title --}}
            <h2 class="text-white text-3xl italic font-light uppercase tracking-wide mb-12 md:text-2xl">
                Масштаб Группы компаний «Россети»
            </h2>

            {{-- Stats layout --}}
            <div class="flex items-end justify-between gap-12 lg:flex-col lg:items-start">
                {{-- Left: vertical stats --}}
                <div class="flex flex-col gap-8">
                    <div>
                        <div class="text-white text-6xl font-light md:text-5xl">82</div>
                        <p class="text-white/80 text-base mt-1">региона присутствия</p>
                    </div>
                    <div>
                        <div class="text-white text-6xl font-light md:text-5xl">69</div>
                        <p class="text-white/80 text-base mt-1">регионов имеют статус СТСО</p>
                    </div>
                    <div>
                        <div class="text-white text-6xl font-light md:text-5xl">122</div>
                        <p class="text-white/80 text-base mt-1 max-w-[280px]">межгосударственные линии электропередачи, по которым осуществляется учет перетоков электроэнергии</p>
                    </div>
                </div>

                {{-- Right: large percentage --}}
                <div class="text-right lg:text-left">
                    <div class="text-white text-[150px] font-bold leading-none lg:text-[100px] md:text-[80px]">~80%</div>
                    <p class="text-white/80 text-xl mt-2 max-w-[350px] ml-auto lg:ml-0">вырабатываемой электроэнергии передается по сетям Группы</p>
                </div>
            </div>
        </div>
    </div>
</section>
