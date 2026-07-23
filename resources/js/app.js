import './bootstrap';
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'
// import Swiper JS
import Swiper from 'swiper';
// import Swiper styles
import 'swiper/css';
import {Navigation, Pagination} from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';

import {gsap} from "gsap";

import $ from 'jquery';

import {ScrollTrigger} from "gsap/ScrollTrigger";
import {ScrollSmoother} from "gsap/ScrollSmoother";

import Lenis from 'lenis'

const lenis = new Lenis();

lenis.on('scroll', () => {
    ScrollTrigger.update();
});

function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
}

requestAnimationFrame(raf);

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

Swiper.use([Navigation, Pagination]);
window.Swiper = Swiper;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

livewire_hot_reload();

// Reveal on scroll function
window.revealOnScroll = function revealOnScroll(delay = 0) {
    return {
        shown: false,
        delay,

        init() {
            this.$el.classList.add('reveal-on-scroll');

            const observer = new IntersectionObserver(
                ([entry]) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            this.shown = true;
                            this.$el.classList.add('is-visible');
                        }, this.delay);
                        observer.unobserve(this.$el);
                    }
                },
                {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px',
                }
            );

            observer.observe(this.$el);
        },
    };
};

// Register as Alpine component for Alpine.data() syntax
document.addEventListener('alpine:init', () => {
    console.log('Alpine initialized');
    Alpine.data('revealOnScroll', (delay = 0) => {
        console.log('Alpine.data revealOnScroll called with delay:', delay);
        return window.revealOnScroll(delay);
    });
});

window.revealAfterPreloader = function revealAfterPreloader(
    delay = 0
) {
    return {
        shown: false,

        timeoutId: null,
        animationFrameId: null,
        preloaderFinishedHandler: null,

        parallaxStarted: false,

        init() {
            /*
             * Сразу устанавливаем начальные положения,
             * пока картинки закрыты прелоадером.
             */
            this.setInitialParallaxPosition();

            const showWelcome = () => {
                if (this.shown) {
                    return;
                }

                this.shown = true;

                this.timeoutId = window.setTimeout(() => {
                    /*
                     * Показываем текст.
                     */
                    this.$el.classList.add('is-visible');

                    /*
                     * Одновременно запускаем одноразовое
                     * плавное движение фоновых картинок.
                     */
                    this.startIntroParallax();
                }, delay);
            };

            this.preloaderFinishedHandler = showWelcome;

            /*
             * Прелоадер уже завершился до запуска Alpine.
             */
            if (
                window.sitePreloaderFinished ||
                !document.getElementById('site-preloader')
            ) {
                showWelcome();

                return;
            }

            /*
             * Ждём полного исчезновения прелоадера.
             */
            window.addEventListener(
                'site-preloader:finished',
                this.preloaderFinishedHandler,
                {
                    once: true,
                }
            );
        },

        setInitialParallaxPosition() {
            const firstLayer = this.$refs.parallaxFirst;
            const secondLayer = this.$refs.parallaxSecond;
            const thirdLayer = this.$refs.parallaxThird;

            /*
             * Дальний слой двигается меньше всего.
             */
            if (firstLayer) {
                firstLayer.style.transform = `
                    translate(-50%, -50%)
                    translate3d(-14px, -8px, 0)
                    scale(1.025)
                `;
            }

            /*
             * Средний слой двигается сильнее.
             */
            if (secondLayer) {
                secondLayer.style.transform = `
                    translateX(-50%)
                    translate3d(24px, 12px, 0)
                    scale(1.025)
                `;
            }

            /*
             * Передний слой получает самое заметное движение.
             */
            if (thirdLayer) {
                thirdLayer.style.transform = `
                    translateX(-50%)
                    translate3d(-38px, 20px, 0)
                    scale(1.025)
                `;
            }
        },

        startIntroParallax() {
            if (this.parallaxStarted) {
                return;
            }

            this.parallaxStarted = true;

            const firstLayer = this.$refs.parallaxFirst;
            const secondLayer = this.$refs.parallaxSecond;
            const thirdLayer = this.$refs.parallaxThird;

            if (
                !firstLayer ||
                !secondLayer ||
                !thirdLayer
            ) {
                return;
            }

            /*
             * Если пользователь отключил анимации,
             * сразу ставим картинки в финальную позицию.
             */
            const prefersReducedMotion =
                window.matchMedia(
                    '(prefers-reduced-motion: reduce)'
                ).matches;

            if (prefersReducedMotion) {
                this.setFinalParallaxPosition();

                return;
            }

            const duration = 2800;
            const startedAt = performance.now();

            /*
             * Плавное замедление к концу.
             */
            const easeOutCubic = (progress) => {
                return 1 - Math.pow(1 - progress, 3);
            };

            const animate = (timestamp) => {
                const elapsed = timestamp - startedAt;

                const progress = Math.min(
                    elapsed / duration,
                    1
                );

                const easedProgress =
                    easeOutCubic(progress);

                /*
                 * Значения постепенно приходят к нулю.
                 */
                const firstX =
                    -14 * (1 - easedProgress);

                const firstY =
                    -8 * (1 - easedProgress);

                const secondX =
                    24 * (1 - easedProgress);

                const secondY =
                    12 * (1 - easedProgress);

                const thirdX =
                    -38 * (1 - easedProgress);

                const thirdY =
                    20 * (1 - easedProgress);

                /*
                 * Лёгкое приближение тоже постепенно
                 * возвращается к обычному масштабу.
                 */
                const scale =
                    1.025 -
                    0.025 * easedProgress;

                firstLayer.style.transform = `
                    translate(-50%, -50%)
                    translate3d(
                        ${firstX}px,
                        ${firstY}px,
                        0
                    )
                    scale(${scale})
                `;

                secondLayer.style.transform = `
                    translateX(-50%)
                    translate3d(
                        ${secondX}px,
                        ${secondY}px,
                        0
                    )
                    scale(${scale})
                `;

                thirdLayer.style.transform = `
                    translateX(-50%)
                    translate3d(
                        ${thirdX}px,
                        ${thirdY}px,
                        0
                    )
                    scale(${scale})
                `;

                if (progress < 1) {
                    this.animationFrameId =
                        requestAnimationFrame(animate);

                    return;
                }

                this.animationFrameId = null;

                /*
                 * В конце ставим точные значения,
                 * чтобы не осталось дробного смещения.
                 */
                this.setFinalParallaxPosition();
            };

            this.animationFrameId =
                requestAnimationFrame(animate);
        },

        setFinalParallaxPosition() {
            const firstLayer = this.$refs.parallaxFirst;
            const secondLayer = this.$refs.parallaxSecond;
            const thirdLayer = this.$refs.parallaxThird;

            if (firstLayer) {
                firstLayer.style.transform = `
                    translate(-50%, -50%)
                    translate3d(0, 0, 0)
                    scale(1)
                `;
            }

            if (secondLayer) {
                secondLayer.style.transform = `
                    translateX(-50%)
                    translate3d(0, 0, 0)
                    scale(1)
                `;
            }

            if (thirdLayer) {
                thirdLayer.style.transform = `
                    translateX(-50%)
                    translate3d(0, 0, 0)
                    scale(1)
                `;
            }
        },

        destroy() {
            if (this.timeoutId !== null) {
                clearTimeout(this.timeoutId);
            }

            if (this.animationFrameId !== null) {
                cancelAnimationFrame(
                    this.animationFrameId
                );
            }

            if (this.preloaderFinishedHandler) {
                window.removeEventListener(
                    'site-preloader:finished',
                    this.preloaderFinishedHandler
                );
            }
        },
    };
};


function scrollToHash(hash) {
    if (!hash) {
        return;
    }

    const target = document.querySelector(hash);

    if (!target) {
        return;
    }

    const headerOffset = 90;
    const top = target.getBoundingClientRect().top + window.scrollY - headerOffset;

    window.scrollTo({
        top,
        behavior: 'smooth',
    });
}

document.addEventListener('click', (e) => {
    const link = e.target.closest('[data-anchor-link]');

    if (!link) {
        return;
    }

    const url = new URL(link.href);
    const currentUrl = new URL(window.location.href);

    if (!url.hash) {
        return;
    }

    e.preventDefault();

    const samePath = url.pathname === currentUrl.pathname;

    if (samePath) {
        history.pushState(null, '', url.hash);
        scrollToHash(url.hash);
        return;
    }

    Livewire.navigate(url.pathname + url.search + url.hash);
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
}

document.addEventListener('livewire:navigated', () => {
    revealOnScroll()
    setTimeout(() => {
        if (window.location.hash) {
            scrollToHash(window.location.hash);
            return;
        }
        scrollToTop();
    }, 100);
});

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        scrollToHash(window.location.hash);
    }, 100);

    initParallax();
});

document.addEventListener('livewire:navigated', () => {
    setTimeout(() => {
        initParallax();
    }, 300);
});

let welcomeScrollContext = null;

function initParallax() {
    /*
     * Удаляем предыдущую анимацию welcome
     * при повторной инициализации Livewire.
     */
    if (welcomeScrollContext) {
        welcomeScrollContext.revert();
        welcomeScrollContext = null;
    }

    const welcome = document.getElementById('welcome');

    if (!welcome) {
        return;
    }

    if (
        window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches
    ) {
        return;
    }

    const layers = welcome.querySelectorAll(
        '[data-welcome-scroll-layer]'
    );

    if (!layers.length) {
        return;
    }

    welcomeScrollContext = gsap.context(() => {
        layers.forEach((layer) => {
            const distance = Number(
                layer.dataset.scrollDistance ?? -30
            );

            gsap.fromTo(
                layer,
                {
                    y: 0,
                },
                {
                    y: distance,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: welcome,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: 1,
                        invalidateOnRefresh: true,
                    },
                }
            );
        });
    }, welcome);

    requestAnimationFrame(() => {
        ScrollTrigger.refresh();
    });
}

