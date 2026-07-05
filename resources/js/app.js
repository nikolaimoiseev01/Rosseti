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

// Initialize Lenis
const lenis = new Lenis();

// Use requestAnimationFrame to continuously update the scroll
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
}


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

function initParallax() {
    ScrollTrigger.getAll().forEach(trigger => trigger.kill());

    gsap.to('#welcome > div:first-child', {
        y: -120,
        ease: 'none',
        scrollTrigger: {
            trigger: '#about',
            start: 'top bottom',
            end: 'top top',
            scrub: true,
            // markers: true,
        },
    });
}

