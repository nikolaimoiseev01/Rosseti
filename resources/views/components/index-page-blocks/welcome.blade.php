<section
    id="welcome"
    class="relative h-screen w-full overflow-hidden rounded-b-[34px]"
    x-data="{
        mouseX: 0,
        mouseY: 0,
        handleMouseMove(e) {
            const rect = $el.getBoundingClientRect();
            this.mouseX = (e.clientX - rect.left - rect.width / 2) / rect.width;
            this.mouseY = (e.clientY - rect.top - rect.height / 2) / rect.height;
        }
    }"
    @mousemove="handleMouseMove($event)"
    @mouseleave="mouseX = 0; mouseY = 0"
>
    <div class="absolute inset-0 overflow-hidden">
        <img
            src="/fixed/welcome-1.png"
            alt=""
            class="absolute left-1/2 top-1/2 h-[calc(100%+120px)] w-[calc(100%+120px)] max-w-none -translate-x-1/2 -translate-y-1/2 object-cover transition-transform duration-300 ease-out"
            :style="`transform: translate(-50%, -50%) translate(${mouseX * 20}px, ${mouseY * 20}px)`"
        >

        <img
            src="/fixed/welcome-2.png"
            alt=""
            class="absolute bottom-[-60px] left-1/2 w-[calc(100%+120px)] max-w-none -translate-x-1/2 object-cover transition-transform duration-300 ease-out"
            :style="`transform: translateX(-50%) translate(${mouseX * 40}px, ${mouseY * 40}px)`"
        >

        <img
            src="/fixed/welcome-3.png"
            alt=""
            class="absolute bottom-[-60px] left-1/2 w-[calc(100%+120px)] max-w-none -translate-x-1/2 object-cover transition-transform duration-300 ease-out"
            :style="`transform: translateX(-50%) translate(${mouseX * 60}px, ${mouseY * 60}px)`"
        >
    </div>

    <div
        x-data="revealOnScroll()"
        class="relative z-20 flex h-full flex-col items-center justify-center text-center"
    >
        <x-logo color="white" class="mb-12 w-[186px]" />

        <h1 class="mb-4 uppercase text-white">
            Создаем потенциал<br>развития страны
        </h1>

        <h3 class="text-2xl font-normal text-white md:text-xl">
            Отчет о социальной ответственности <br>
            и корпоративном устойчивом развитии
        </h3>
    </div>

    <h3
        x-data="revealOnScroll()"
        class="absolute bottom-[104px] left-1/2 -translate-x-1/2 text-2xl text-white"
    >
        2025
    </h3>
</section>
