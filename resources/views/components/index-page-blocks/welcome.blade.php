<section
    id="welcome"
    x-data="revealAfterPreloader(0)"
    class="page-block page-block--welcome welcome-reveal relative h-screen w-full overflow-hidden rounded-b-[34px]"
>
    <style>
        [data-welcome-scroll-layer] {
            will-change: transform;
            backface-visibility: hidden;
        }

        .welcome-parallax-layer {
            will-change: transform;
            backface-visibility: hidden;
            transform-style: preserve-3d;
            transform-origin: center center;
        }

        .welcome-reveal-item {
            opacity: 0;
            filter: blur(8px);
            transform: translate3d(0, 40px, 0);

            transition:
                opacity 1s ease,
                filter 1s ease,
                transform 1s cubic-bezier(.22, 1, .36, 1);

            transition-delay:
                var(--welcome-reveal-delay, 0ms);

            will-change: opacity, filter, transform;
        }

        .welcome-reveal.is-visible
        .welcome-reveal-item {
            opacity: 1;
            filter: blur(0);
            transform: translate3d(0, 0, 0);
        }

        @media (prefers-reduced-motion: reduce) {
            .welcome-reveal-item {
                filter: none;
                transform: none;
                transition-duration: 0.25s;
            }
        }
    </style>

    <div class="absolute inset-0 overflow-hidden">
        <div
            data-welcome-scroll-layer
            data-scroll-distance="-18"
            class="absolute inset-0"
        >
            <img
                x-ref="parallaxFirst"
                src="/fixed/welcome-1.png"
                alt=""
                class="welcome-parallax-layer absolute left-1/2 top-1/2 h-[calc(100%+120px)] w-[calc(100%+120px)] max-w-none object-cover"
                style="transform: translate(-50%, -50%) translate3d(0, 0, 0);"
                data-no-lightbox
            >
        </div>

        <div
            data-welcome-scroll-layer
            data-scroll-distance="-30"
            class="absolute inset-0"
        >
            <img
                x-ref="parallaxSecond"
                src="/fixed/welcome-2.png"
                alt=""
                class="welcome-parallax-layer absolute bottom-[-60px] left-1/2 w-[calc(100%+120px)] max-w-none object-cover"
                style="transform: translateX(-50%) translate3d(0, 0, 0);"
                data-no-lightbox
            >
        </div>

        <div
            data-welcome-scroll-layer
            data-scroll-distance="-42"
            class="absolute inset-0"
        >
            <img
                x-ref="parallaxThird"
                src="/fixed/welcome-3.png"
                alt=""
                class="welcome-parallax-layer absolute bottom-[-60px] left-1/2 w-[calc(100%+120px)] max-w-none object-cover"
                style="transform: translateX(-50%) translate3d(0, 0, 0);"
                data-no-lightbox
            >
        </div>
    </div>

    <div
        class="pointer-events-none relative z-20 flex h-full flex-col items-center justify-center text-center"
    >
        <div
            class="welcome-reveal-item mb-12"
            style="--welcome-reveal-delay: 0ms"
        >
            <x-logo
                color="white"
                class="w-[186px]"
            />
        </div>

        <h1
            class="welcome-reveal-item mb-4 uppercase text-white"
            style="--welcome-reveal-delay: 180ms"
        >
            Создаем потенциал<br>
            развития страны
        </h1>

        <h3
            class="welcome-reveal-item text-2xl font-normal text-white md:!text-xl mb-20"
            style="--welcome-reveal-delay: 360ms"
        >
            Отчет о социальной ответственности
            <br>
            и корпоративном устойчивом развитии
        </h3>

        <h3
            class="welcome-reveal-item pointer-events-none z-20 text-2xl text-white"
            style="--welcome-reveal-delay: 540ms"
        >
            2025
        </h3>
    </div>

</section>
