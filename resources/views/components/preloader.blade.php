@props([
    'color' => '#0E3A5C',
    'background' => '#FFFFFF',
])

<style>
    html.is-preloading {
        overflow: hidden;
    }

    .site-preloader {
        --site-preloader-color: {{ $color }};
        --site-preloader-background: {{ $background }};

        position: fixed;
        inset: 0;
        z-index: 99999;

        display: flex;
        align-items: center;
        justify-content: center;

        background: var(--site-preloader-background);

        transform: translateY(0);
        transition:
            transform 0.9s cubic-bezier(0.76, 0, 0.24, 1),
            visibility 0s linear 0.9s;

        will-change: transform;
        overflow: hidden;
    }

    .site-preloader.is-hidden {
        transform: translateY(-100%);
        visibility: hidden;
    }

    .site-preloader__logo {
        display: block;

        width: min(240px, 58vw);
        height: auto;

        opacity: 1;
        transform: scale(1);

        transition:
            opacity 0.35s ease,
            transform 0.5s ease;

        will-change: opacity, transform;
    }

    .site-preloader.is-hidden .site-preloader__logo {
        opacity: 0;
        transform: scale(0.96);
    }

    .site-preloader__logo-base {
        fill: var(--site-preloader-color);
        opacity: 0.16;
    }

    .site-preloader__logo-progress {
        fill: var(--site-preloader-color);
    }

    @media (prefers-reduced-motion: reduce) {
        .site-preloader {
            transition-duration: 0.25s;
        }

        .site-preloader__logo {
            transition-duration: 0.2s;
        }
    }
</style>

<div
    id="site-preloader"
    class="site-preloader"
    aria-hidden="true"
>
    <svg
        class="site-preloader__logo"
        width="186"
        height="57"
        viewBox="0 0 186 57"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
    >
        <defs>
            {{-- Маска, ширина которой изменяется через JavaScript --}}
            <mask
                id="rosseti-loader-mask"
                maskUnits="userSpaceOnUse"
                maskContentUnits="userSpaceOnUse"
                x="0"
                y="0"
                width="186"
                height="57"
            >
                <rect
                    id="rosseti-loader-progress"
                    x="0"
                    y="0"
                    width="0"
                    height="57"
                    fill="white"
                />
            </mask>

            {{-- Форма логотипа --}}
            <symbol
                id="rosseti-preloader-logo-shape"
                viewBox="0 0 186 57"
            >
                <path d="M78.285 19.0504C77.6734 18.472 76.9226 18.0449 76.0532 17.7691C75.1762 17.4856 74.2316 17.3516 73.1985 17.3516H66.2471V39.6571H70.8086V31.519H73.4581C74.5063 31.519 75.451 31.3485 76.2903 31.0019C77.1239 30.6609 77.8484 30.184 78.4393 29.5692C79.0132 28.9448 79.4724 28.1902 79.7904 27.3111C80.099 26.4415 80.2609 25.4686 80.2609 24.4075C80.2609 23.1875 80.0859 22.1398 79.7415 21.2454C79.399 20.3567 78.9079 19.6308 78.2887 19.0523L78.285 19.0504ZM75.0163 26.5488C74.5044 26.9797 73.9023 27.1866 73.2361 27.1866H70.8067V21.6418H73.1985C74.002 21.6418 74.6324 21.8525 75.0953 22.2739C75.5507 22.6876 75.7878 23.3771 75.7878 24.3424C75.7878 25.3881 75.53 26.1159 75.0163 26.5507V26.5488Z" />

                <path d="M95.979 19.4613C95.4144 18.7928 94.6918 18.247 93.8055 17.8313C92.9192 17.41 91.8823 17.2031 90.6911 17.2031C89.404 17.2031 88.3163 17.4176 87.4299 17.8562C86.538 18.2948 85.8078 18.8599 85.247 19.5455C84.675 20.2293 84.2572 20.9897 84.0069 21.8381C83.7642 22.6751 83.623 23.5217 83.623 24.3548V32.2956C83.623 33.3107 83.7642 34.2703 84.0239 35.1839C84.2949 36.109 84.707 36.9096 85.2677 37.6048C85.8436 38.2982 86.5681 38.8459 87.4601 39.252C88.352 39.6618 89.4378 39.863 90.6911 39.863C91.7167 39.863 92.6538 39.6982 93.5082 39.3669C94.3606 39.0355 95.0964 38.5586 95.7061 37.9266C96.3384 37.2945 96.8126 36.5361 97.1551 35.6436C97.5032 34.7606 97.6801 33.7627 97.6801 32.6538V24.3548C97.6801 23.4757 97.5371 22.6138 97.2567 21.7558C96.9688 20.9035 96.5529 20.1335 95.979 19.4613ZM93.0754 32.9717C93.0754 33.7225 92.8458 34.3029 92.3697 34.7338C91.8973 35.1609 91.3328 35.3773 90.6911 35.3773C89.7841 35.3773 89.1443 35.1034 88.751 34.548C88.3596 33.9907 88.1676 33.2878 88.1676 32.4278V24.1595C88.1676 23.9047 88.2128 23.6308 88.305 23.3436C88.4066 23.0524 88.5534 22.7881 88.751 22.5391C88.9504 22.2978 89.2082 22.0967 89.5244 21.9358C89.8387 21.7711 90.2338 21.6887 90.6892 21.6887C91.1446 21.6887 91.5304 21.7903 91.8334 21.9607C92.142 22.1522 92.3866 22.361 92.5767 22.6177C92.7536 22.8801 92.8947 23.1482 92.9681 23.4259C93.0415 23.6979 93.0735 23.9507 93.0735 24.1576V32.9717H93.0754Z" />

                <path d="M106.779 23.3416C106.859 23.0505 106.995 22.7862 107.189 22.5372C107.375 22.2959 107.629 22.091 107.932 21.9301C108.25 21.7692 108.638 21.6887 109.11 21.6887C109.541 21.6887 109.921 21.7749 110.237 21.9396C110.548 22.1159 110.813 22.3246 111.02 22.5506C111.229 22.7881 111.381 23.0486 111.485 23.3397C111.573 23.627 111.639 23.8856 111.684 24.0905L116.001 22.7766C115.856 22.0546 115.593 21.3555 115.249 20.6756C114.88 20.0052 114.419 19.4153 113.854 18.9058C113.293 18.3849 112.607 17.9731 111.811 17.6647C111.013 17.3525 110.113 17.2031 109.11 17.2031C107.819 17.2031 106.735 17.4138 105.84 17.8524C104.951 18.2929 104.231 18.856 103.67 19.5398C103.117 20.2255 102.704 20.9858 102.458 21.8362C102.202 22.6713 102.07 23.5178 102.07 24.351V32.2956C102.07 33.3088 102.211 34.2626 102.477 35.1801C102.74 36.1013 103.149 36.9038 103.702 37.601C104.255 38.2943 104.989 38.8421 105.877 39.2443C106.764 39.658 107.847 39.861 109.11 39.861C110.888 39.861 112.401 39.3669 113.638 38.3863C114.872 37.3999 115.655 36.0439 115.973 34.3144L111.626 33.0292C111.538 33.7589 111.257 34.3258 110.772 34.7453C110.292 35.159 109.727 35.3697 109.112 35.3697C108.196 35.3697 107.567 35.0996 107.196 34.5404C106.831 33.983 106.645 33.2801 106.645 32.422V24.1499C106.645 23.8952 106.683 23.6213 106.777 23.334L106.779 23.3416Z" />

                <path d="M124.534 23.3416C124.625 23.0505 124.76 22.7862 124.941 22.5372C125.133 22.2959 125.387 22.091 125.697 21.9301C126.013 21.7692 126.407 21.6887 126.866 21.6887C127.325 21.6887 127.675 21.7749 127.995 21.9396C128.311 22.1159 128.571 22.3246 128.783 22.5506C128.994 22.7881 129.148 23.0486 129.237 23.3397C129.327 23.627 129.399 23.8856 129.444 24.0905L133.759 22.7766C133.61 22.0546 133.364 21.3555 133.002 20.6756C132.654 20.0052 132.184 19.4153 131.615 18.9058C131.047 18.3849 130.362 17.9731 129.576 17.6647C128.77 17.3525 127.865 17.2031 126.866 17.2031C125.58 17.2031 124.497 17.4138 123.606 17.8524C122.707 18.2929 121.984 18.856 121.431 19.5398C120.878 20.2255 120.471 20.9858 120.217 21.8362C119.969 22.6713 119.845 23.5178 119.845 24.351V32.2956C119.845 33.3088 119.969 34.2626 120.234 35.1801C120.492 36.1013 120.897 36.9038 121.459 37.601C122.016 38.2943 122.746 38.8421 123.637 39.2443C124.523 39.658 125.599 39.861 126.864 39.861C128.646 39.861 130.153 39.3669 131.393 38.3863C132.63 37.3999 133.405 36.0439 133.721 34.3144L129.384 33.0292C129.303 33.7589 129.007 34.3258 128.527 34.7453C128.048 35.159 127.494 35.3697 126.864 35.3697C125.957 35.3697 125.323 35.0996 124.956 34.5404C124.587 33.983 124.402 33.2801 124.402 32.422V24.1499C124.402 23.8952 124.446 23.6213 124.53 23.334L124.534 23.3416Z" />

                <path d="M138.107 39.6551H150.859V35.2691H142.671V30.5269H149.722V26.2577H142.671V21.6476H150.859V17.3516H138.107V39.6551Z" />

                <path d="M153.373 21.5805H158.066V39.6551H162.603V21.5805H167.289V17.3516H153.373V21.5805Z" />

                <path d="M181.877 17.3516L175.613 30.3009H175.549V17.3516H171.01V39.6551H175.293L181.405 27.5141H181.433V39.6551H186V17.3516H181.877Z" />

                <path d="M33.6841 17.1425L17.3613 54.8623C20.6488 56.2337 24.245 56.9979 28.0349 56.9979C31.8249 56.9979 35.2479 56.2662 38.4827 54.937L34.4293 17.2536C34.1715 17.2421 33.9231 17.2057 33.686 17.1406L33.6841 17.1425Z" />

                <path d="M31.8525 16.0312L1.16211 36.6111C3.26597 43.8126 8.08339 49.8189 14.4063 53.412L32.417 16.5522C32.2175 16.4028 32.02 16.2266 31.8544 16.0312H31.8525Z" />

                <path d="M35.8232 17.0676L41.5703 53.462C47.9534 49.8574 52.8141 43.8108 54.9066 36.5384L36.7303 16.6328C36.4574 16.8205 36.1431 16.9661 35.8232 17.0676Z" />

                <path d="M32.245 10.4345L26.3775 0C18.7486 0.446263 11.9365 3.99913 7.14355 9.44431L30.9917 12.3517C31.21 11.5894 31.6484 10.9287 32.245 10.4364V10.4345Z" />

                <path d="M38.4092 13.5751C38.3772 14.3202 38.1476 15.0116 37.7656 15.5824L55.7218 32.9043C55.9382 31.4659 56.0587 29.9873 56.0587 28.4704C56.0587 22.3491 54.1543 16.6817 50.9345 12.0391L38.4111 13.5732L38.4092 13.5751Z" />

                <path d="M30.8804 13.8417L4.83436 12.4531C1.78207 17.0192 0 22.5314 0 28.4765C0 30.0757 0.129845 31.6539 0.38577 33.1785L31.0893 14.8089C30.9764 14.5082 30.9124 14.1769 30.8804 13.8417Z" />

                <path d="M34.7117 9.55348C36.2548 9.59561 37.5646 10.5628 38.1291 11.9342L48.8253 9.3428C44.0737 3.98381 37.3444 0.480738 29.8115 0L33.7652 9.67031C34.0663 9.60328 34.3805 9.54965 34.7136 9.55348H34.7117Z" />
            </symbol>
        </defs>

        {{-- Бледная версия логотипа --}}
        <g class="site-preloader__logo-base">
            <use
                href="#rosseti-preloader-logo-shape"
                xlink:href="#rosseti-preloader-logo-shape"
            />
        </g>

        {{-- Синяя версия, открываемая маской --}}
        <g
            class="site-preloader__logo-progress"
            mask="url(#rosseti-loader-mask)"
        >
            <use
                href="#rosseti-preloader-logo-shape"
                xlink:href="#rosseti-preloader-logo-shape"
            />
        </g>
    </svg>
</div>

@push('page-js')
    <script data-navigate-once>
        (() => {
            let livewireNavigationStarted = false;

            function removeCurrentPreloader() {
                const preloader =
                    document.getElementById('site-preloader');

                document.documentElement.classList.remove(
                    'is-preloading'
                );

                preloader?.remove();
            }

            function initSitePreloader() {
                const preloader =
                    document.getElementById('site-preloader');

                const progressRect =
                    document.getElementById(
                        'rosseti-loader-progress'
                    );

                if (!preloader || !progressRect) {
                    return;
                }

                if (preloader.dataset.initialized === 'true') {
                    return;
                }

                preloader.dataset.initialized = 'true';

                const logoWidth = 186;

                /*
                 * Логотип заполняется минимум 5 секунд.
                 */
                const minimumLoadingDuration = 1000;

                /*
                 * После пяти секунд последние 8%
                 * заполняются отдельно.
                 */
                const finishingDuration = 500;

                /*
                 * Пауза с полностью заполненным логотипом.
                 */
                const completedLogoPause = 500;

                const startedAt = performance.now();

                let pageLoaded =
                    document.readyState === 'complete';

                let finishingStartedAt = null;
                let animationFrameId = null;
                let removeFallbackTimer = null;
                let hidden = false;

                document.documentElement.classList.add(
                    'is-preloading'
                );

                function updateMask(progress) {
                    const normalizedProgress = Math.max(
                        0,
                        Math.min(progress, 100)
                    );

                    const width =
                        logoWidth *
                        normalizedProgress /
                        100;

                    progressRect.setAttribute(
                        'width',
                        width.toFixed(3)
                    );
                }

                function notifyPreloaderFinished() {
                    if (window.sitePreloaderFinished) {
                        return;
                    }

                    window.sitePreloaderFinished = true;

                    window.dispatchEvent(
                        new CustomEvent('site-preloader:finished')
                    );
                }

                function removePreloader() {
                    if (animationFrameId !== null) {
                        cancelAnimationFrame(
                            animationFrameId
                        );

                        animationFrameId = null;
                    }

                    if (removeFallbackTimer !== null) {
                        clearTimeout(
                            removeFallbackTimer
                        );

                        removeFallbackTimer = null;
                    }

                    document.documentElement.classList.remove(
                        'is-preloading'
                    );

                    if (preloader.isConnected) {
                        preloader.remove();
                    }
                }

                function hidePreloader() {
                    if (hidden) {
                        return;
                    }

                    hidden = true;

                    window.setTimeout(() => {
                        preloader.classList.add(
                            'is-hidden'
                        );

                        document.documentElement.classList.remove(
                            'is-preloading'
                        );

                        notifyPreloaderFinished();

                        preloader.addEventListener(
                            'transitionend',
                            (event) => {
                                if (
                                    event.target === preloader &&
                                    event.propertyName ===
                                    'transform'
                                ) {
                                    removePreloader();
                                }
                            },
                            {
                                once: true,
                            }
                        );

                        /*
                         * Страховка, если transitionend
                         * не сработает.
                         */
                        removeFallbackTimer =
                            window.setTimeout(
                                removePreloader,
                                1500
                            );
                    }, completedLogoPause);
                }

                function animateProgress(timestamp) {
                    const elapsedTime =
                        timestamp - startedAt;

                    /*
                     * Первые 5 секунд заполняем логотип
                     * строго от 0 до 92%.
                     */
                    if (
                        elapsedTime <
                        minimumLoadingDuration
                    ) {
                        const timeProgress =
                            elapsedTime /
                            minimumLoadingDuration;

                        /*
                         * Линейное заполнение позволяет
                         * хорошо видеть всю анимацию.
                         */
                        const progress =
                            timeProgress * 92;

                        updateMask(progress);

                        animationFrameId =
                            requestAnimationFrame(
                                animateProgress
                            );

                        return;
                    }

                    /*
                     * Если прошло 5 секунд, но страница
                     * ещё не загрузилась, держим 92%.
                     */
                    if (!pageLoaded) {
                        updateMask(92);

                        animationFrameId =
                            requestAnimationFrame(
                                animateProgress
                            );

                        return;
                    }

                    /*
                     * После загрузки страницы заполняем
                     * оставшиеся 8%.
                     */
                    if (finishingStartedAt === null) {
                        finishingStartedAt = timestamp;
                    }

                    const finishingElapsed =
                        timestamp -
                        finishingStartedAt;

                    const finishingProgress = Math.min(
                        finishingElapsed /
                        finishingDuration,
                        1
                    );

                    const progress =
                        92 +
                        finishingProgress * 8;

                    updateMask(progress);

                    if (finishingProgress >= 1) {
                        updateMask(100);
                        hidePreloader();

                        return;
                    }

                    animationFrameId =
                        requestAnimationFrame(
                            animateProgress
                        );
                }

                function handlePageLoaded() {
                    pageLoaded = true;
                }

                if (!pageLoaded) {
                    window.addEventListener(
                        'load',
                        handlePageLoaded,
                        {
                            once: true,
                        }
                    );
                }

                updateMask(0);

                animationFrameId =
                    requestAnimationFrame(
                        animateProgress
                    );
            }

            /*
             * На первой загрузке livewire:navigated
             * тоже может сработать. Поэтому сначала
             * проверяем, был ли реальный переход.
             */
            document.addEventListener(
                'livewire:navigate',
                () => {
                    livewireNavigationStarted = true;
                }
            );

            document.addEventListener(
                'livewire:navigated',
                () => {
                    if (!livewireNavigationStarted) {
                        return;
                    }

                    livewireNavigationStarted = false;

                    removeCurrentPreloader();
                }
            );

            if (
                document.readyState === 'loading'
            ) {
                document.addEventListener(
                    'DOMContentLoaded',
                    initSitePreloader,
                    {
                        once: true,
                    }
                );
            } else {
                initSitePreloader();
            }
        })();
    </script>
@endpush
