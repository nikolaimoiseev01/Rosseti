<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="/fonts/fonts.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .lightbox-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lightbox-modal.active {
            display: flex;
            opacity: 1;
        }

        .lightbox-modal img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            transform: scale(0.8);
            transition: transform 0.3s ease;
            cursor: grab;
        }

        .lightbox-modal img:active {
            cursor: grabbing;
        }

        .lightbox-modal.active img {
            transform: scale(1);
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            cursor: pointer;
            z-index: 10000;
            transition: opacity 0.3s ease;
        }

        .lightbox-close:hover {
            opacity: 0.7;
        }

        /*
         * Теперь класс lightbox-clickable добавлять JS-ом не нужно.
         * Cursor можно назначить всем изображениям,
         * кроме явно исключённых через data-no-lightbox.
         */
        img:not([data-no-lightbox]) {
            cursor: pointer;
        }

        img:not([data-no-lightbox]):hover {
            /* При необходимости можно вернуть:
            transform: scale(1.02);
            */
        }

        .lightbox-zoom-controls {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 15px;
            background: #747474;
            padding: 12px 20px;
            border-radius: 30px;
            backdrop-filter: blur(10px);
            z-index: 10000;
        }

        .lightbox-zoom-slider {
            width: 200px;
            height: 6px;
            -webkit-appearance: none;
            appearance: none;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            outline: none;
            cursor: pointer;
        }

        .lightbox-zoom-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .lightbox-zoom-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        .lightbox-zoom-slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            cursor: pointer;
            border: none;
            transition: transform 0.2s ease;
        }

        .lightbox-zoom-slider::-moz-range-thumb:hover {
            transform: scale(1.2);
        }

        .lightbox-zoom-level {
            color: white;
            font-size: 14px;
            min-width: 45px;
            text-align: center;
        }

        .lightbox-zoom-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease;
        }

        .lightbox-zoom-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>


    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=110978392', 'ym');

        ym(110978392, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/110978392" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body class="antialiased flex flex-col min-h-screen">

 <x-preloader/>

<x-header/>

{{ $slot ?? '' }}

@yield('content')

<x-footer/>

@stack('page-js')


{{-- ========================================================= --}}
{{-- LIGHTBOX --}}
{{-- ========================================================= --}}

@persist('global-lightbox')
<div
    class="lightbox-modal"
    id="lightbox"
>
    <span
        class="lightbox-close"
        id="lightbox-close"
    >
        &times;
    </span>

    <img
        src=""
        alt=""
        class="bg-white p-2"
        id="lightbox-image"
        data-no-lightbox
    >

    <div class="lightbox-zoom-controls">

        <button
            type="button"
            class="lightbox-zoom-btn"
            id="zoom-out"
        >
            −
        </button>

        <input
            type="range"
            class="lightbox-zoom-slider"
            id="zoom-slider"
            min="1"
            max="5"
            step="0.1"
            value="1"
        >

        <span
            class="lightbox-zoom-level"
            id="zoom-level"
        >
            100%
        </span>

        <button
            type="button"
            class="lightbox-zoom-btn"
            id="zoom-in"
        >
            +
        </button>

    </div>
</div>
@endpersist


<script>
    /**
     * ============================================================
     * LIGHTBOX
     * ============================================================
     *
     * Здесь специально используется event delegation.
     *
     * Поэтому после:
     *
     * wire:navigate
     * livewire:navigated
     * Livewire update
     *
     * ничего повторно инициализировать не требуется.
     */

    (() => {

        /*
         * Защита от повторного подключения скрипта.
         *
         * При Livewire navigation layout обычно не выполняется
         * повторно, но эта проверка делает код безопаснее.
         */
        if (window.__globalLightboxInitialized) {
            return;
        }

        window.__globalLightboxInitialized = true;


        let currentZoom = 1;

        let isDragging = false;

        let startX = 0;
        let startY = 0;

        let translateX = 0;
        let translateY = 0;


        /**
         * Каждый раз получаем актуальные элементы из DOM.
         *
         * Это важно для Livewire, потому что DOM страницы
         * может изменяться после навигации.
         */
        function getLightboxElements() {
            return {
                lightbox: document.getElementById('lightbox'),
                image: document.getElementById('lightbox-image'),
                close: document.getElementById('lightbox-close'),
                zoomSlider: document.getElementById('zoom-slider'),
                zoomLevel: document.getElementById('zoom-level'),
                zoomIn: document.getElementById('zoom-in'),
                zoomOut: document.getElementById('zoom-out'),
            };
        }


        /**
         * Обновление transform картинки.
         */
        function updateImageTransform() {
            const { image } = getLightboxElements();

            if (!image) {
                return;
            }

            image.style.transform =
                `scale(${currentZoom}) translate(${translateX}px, ${translateY}px)`;
        }


        /**
         * Сброс zoom/pan.
         */
        function resetZoom() {
            const {
                zoomSlider,
                zoomLevel
            } = getLightboxElements();

            currentZoom = 1;

            translateX = 0;
            translateY = 0;

            if (zoomSlider) {
                zoomSlider.value = 1;
            }

            if (zoomLevel) {
                zoomLevel.textContent = '100%';
            }

            updateImageTransform();
        }


        /**
         * Открытие lightbox.
         */
        function openLightbox(sourceImage) {
            const {
                lightbox,
                image
            } = getLightboxElements();

            if (!lightbox || !image) {
                return;
            }

            /*
             * currentSrc правильнее src,
             * если используется srcset / picture.
             */
            image.src =
                sourceImage.currentSrc ||
                sourceImage.src;

            /*
             * Можно перенести alt оригинальной картинки.
             */
            image.alt =
                sourceImage.alt || '';

            resetZoom();

            lightbox.classList.add('active');

            document.body.style.overflow = 'hidden';
        }


        /**
         * Закрытие lightbox.
         */
        function closeLightbox() {
            const {
                lightbox,
                image
            } = getLightboxElements();

            if (!lightbox) {
                return;
            }

            lightbox.classList.remove('active');

            document.body.style.overflow = '';

            isDragging = false;

            resetZoom();

            /*
             * Можно очистить src после закрытия.
             */
            if (image) {
                image.style.cursor = 'grab';
                image.style.transition = 'transform 0.3s ease';
            }
        }


        /**
         * ========================================================
         * CLICK
         * ========================================================
         *
         * Один обработчик на document.
         *
         * Работает и для картинок, которые появились
         * после Livewire navigation.
         */
        document.addEventListener('click', function (event) {

            /*
             * ----------------------------------------------------
             * CLOSE
             * ----------------------------------------------------
             */

            const closeButton =
                event.target.closest('#lightbox-close');

            if (closeButton) {
                event.preventDefault();

                closeLightbox();

                return;
            }


            /*
             * ----------------------------------------------------
             * ZOOM IN
             * ----------------------------------------------------
             */

            const zoomInButton =
                event.target.closest('#zoom-in');

            if (zoomInButton) {
                event.preventDefault();

                const {
                    zoomSlider,
                    zoomLevel
                } = getLightboxElements();

                currentZoom =
                    Math.min(5, currentZoom + 0.5);

                if (zoomSlider) {
                    zoomSlider.value = currentZoom;
                }

                if (zoomLevel) {
                    zoomLevel.textContent =
                        Math.round(currentZoom * 100) + '%';
                }

                updateImageTransform();

                return;
            }


            /*
             * ----------------------------------------------------
             * ZOOM OUT
             * ----------------------------------------------------
             */

            const zoomOutButton =
                event.target.closest('#zoom-out');

            if (zoomOutButton) {
                event.preventDefault();

                const {
                    zoomSlider,
                    zoomLevel
                } = getLightboxElements();

                currentZoom =
                    Math.max(1, currentZoom - 0.5);

                if (zoomSlider) {
                    zoomSlider.value = currentZoom;
                }

                if (zoomLevel) {
                    zoomLevel.textContent =
                        Math.round(currentZoom * 100) + '%';
                }

                updateImageTransform();

                return;
            }


            /*
             * ----------------------------------------------------
             * CLICK OUTSIDE IMAGE
             * ----------------------------------------------------
             */

            const {
                lightbox
            } = getLightboxElements();

            if (
                lightbox &&
                event.target === lightbox
            ) {
                closeLightbox();

                return;
            }


            /*
             * ----------------------------------------------------
             * OPEN IMAGE
             * ----------------------------------------------------
             */

            const clickedImage =
                event.target.closest(
                    'img:not([data-no-lightbox])'
                );

            if (!clickedImage) {
                return;
            }

            /*
             * Дополнительная страховка.
             */
            if (
                clickedImage.id === 'lightbox-image'
            ) {
                return;
            }

            event.preventDefault();

            openLightbox(clickedImage);
        });


        /**
         * ========================================================
         * RANGE INPUT
         * ========================================================
         */
        document.addEventListener('input', function (event) {

            if (
                event.target.id !== 'zoom-slider'
            ) {
                return;
            }

            const {
                zoomLevel
            } = getLightboxElements();

            currentZoom =
                parseFloat(event.target.value);

            if (zoomLevel) {
                zoomLevel.textContent =
                    Math.round(currentZoom * 100) + '%';
            }

            updateImageTransform();
        });


        /**
         * ========================================================
         * MOUSE WHEEL ZOOM
         * ========================================================
         */
        document.addEventListener(
            'wheel',
            function (event) {

                const {
                    lightbox,
                    zoomSlider,
                    zoomLevel
                } = getLightboxElements();

                if (
                    !lightbox ||
                    !lightbox.classList.contains('active')
                ) {
                    return;
                }

                /*
                 * Зумим только если курсор находится
                 * внутри lightbox.
                 */
                if (
                    !event.target.closest('#lightbox')
                ) {
                    return;
                }

                event.preventDefault();

                const delta =
                    event.deltaY > 0
                        ? -0.1
                        : 0.1;

                currentZoom =
                    Math.max(
                        1,
                        Math.min(
                            5,
                            currentZoom + delta
                        )
                    );

                /*
                 * Убираем погрешности вроде:
                 * 1.2000000000000002
                 */
                currentZoom =
                    Math.round(currentZoom * 10) / 10;

                if (zoomSlider) {
                    zoomSlider.value = currentZoom;
                }

                if (zoomLevel) {
                    zoomLevel.textContent =
                        Math.round(
                            currentZoom * 100
                        ) + '%';
                }

                updateImageTransform();
            },
            {
                passive: false
            }
        );


        /**
         * ========================================================
         * DRAG START
         * ========================================================
         */
        document.addEventListener(
            'mousedown',
            function (event) {

                if (
                    event.target.id !==
                    'lightbox-image'
                ) {
                    return;
                }

                if (currentZoom <= 1) {
                    return;
                }

                event.preventDefault();

                isDragging = true;

                startX =
                    event.clientX - translateX;

                startY =
                    event.clientY - translateY;

                event.target.style.cursor =
                    'grabbing';

                event.target.style.transition =
                    'none';
            }
        );


        /**
         * ========================================================
         * DRAG MOVE
         * ========================================================
         */
        document.addEventListener(
            'mousemove',
            function (event) {

                if (!isDragging) {
                    return;
                }

                translateX =
                    event.clientX - startX;

                translateY =
                    event.clientY - startY;

                updateImageTransform();
            }
        );


        /**
         * ========================================================
         * DRAG END
         * ========================================================
         */
        document.addEventListener(
            'mouseup',
            function () {

                if (!isDragging) {
                    return;
                }

                isDragging = false;

                const {
                    image
                } = getLightboxElements();

                if (!image) {
                    return;
                }

                image.style.cursor =
                    'grab';

                image.style.transition =
                    'transform 0.3s ease';
            }
        );


        /**
         * Когда курсор ушёл за пределы окна
         * во время drag.
         */
        window.addEventListener(
            'blur',
            function () {

                if (!isDragging) {
                    return;
                }

                isDragging = false;

                const {
                    image
                } = getLightboxElements();

                if (image) {
                    image.style.cursor =
                        'grab';

                    image.style.transition =
                        'transform 0.3s ease';
                }
            }
        );


        /**
         * ========================================================
         * ESC
         * ========================================================
         */
        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key !== 'Escape') {
                    return;
                }

                const {
                    lightbox
                } = getLightboxElements();

                if (
                    !lightbox ||
                    !lightbox.classList.contains('active')
                ) {
                    return;
                }

                closeLightbox();
            }
        );


        /**
         * ========================================================
         * LIVEWIRE NAVIGATION
         * ========================================================
         *
         * Переинициализация больше НЕ нужна.
         *
         * Но если пользователь перешёл на другую страницу,
         * когда lightbox был открыт, гарантированно возвращаем
         * body в нормальное состояние.
         */
        document.addEventListener(
            'livewire:navigating',
            function () {

                const {
                    lightbox
                } = getLightboxElements();

                if (
                    lightbox &&
                    lightbox.classList.contains('active')
                ) {
                    closeLightbox();
                }
            }
        );

    })();
</script>

</body>
</html>
