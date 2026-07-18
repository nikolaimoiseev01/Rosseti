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

        .lightbox-clickable {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .lightbox-clickable:hover {
            transform: scale(1.02);
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
</head>
<body class="antialiased flex flex-col min-h-screen">
<x-preloader/>
<x-header/>
{{ $slot ?? '' }}
@yield('content')
<x-footer/>
@stack('page-js')

<!-- Lightbox Modal -->
<div class="lightbox-modal" id="lightbox">
    <span class="lightbox-close" id="lightbox-close">&times;</span>
    <img src="" alt="" class="bg-white p-2" id="lightbox-image">
    <div class="lightbox-zoom-controls">
        <button class="lightbox-zoom-btn" id="zoom-out">−</button>
        <input type="range" class="lightbox-zoom-slider" id="zoom-slider" min="1" max="5" step="0.1" value="1">
        <span class="lightbox-zoom-level" id="zoom-level">100%</span>
        <button class="lightbox-zoom-btn" id="zoom-in">+</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxClose = document.getElementById('lightbox-close');
        const zoomSlider = document.getElementById('zoom-slider');
        const zoomLevel = document.getElementById('zoom-level');
        const zoomIn = document.getElementById('zoom-in');
        const zoomOut = document.getElementById('zoom-out');

        let currentZoom = 1;
        let isDragging = false;
        let startX, startY, translateX = 0, translateY = 0;

        // Add click event to all images
        function setupLightbox() {
            const images = document.querySelectorAll('img:not(.lightbox-clickable):not([data-no-lightbox])');
            images.forEach(img => {
                img.classList.add('lightbox-clickable');
                img.addEventListener('click', function(e) {
                    e.preventDefault();
                    lightboxImage.src = this.src;
                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    resetZoom();
                });
            });
        }

        // Reset zoom
        function resetZoom() {
            currentZoom = 1;
            translateX = 0;
            translateY = 0;
            zoomSlider.value = 1;
            zoomLevel.textContent = '100%';
            updateImageTransform();
        }

        // Update image transform
        function updateImageTransform() {
            lightboxImage.style.transform = `scale(${currentZoom}) translate(${translateX}px, ${translateY}px)`;
        }

        // Zoom slider
        zoomSlider.addEventListener('input', function() {
            currentZoom = parseFloat(this.value);
            zoomLevel.textContent = Math.round(currentZoom * 100) + '%';
            updateImageTransform();
        });

        // Zoom buttons
        zoomIn.addEventListener('click', function() {
            if (currentZoom < 5) {
                currentZoom = Math.min(5, currentZoom + 0.5);
                zoomSlider.value = currentZoom;
                zoomLevel.textContent = Math.round(currentZoom * 100) + '%';
                updateImageTransform();
            }
        });

        zoomOut.addEventListener('click', function() {
            if (currentZoom > 1) {
                currentZoom = Math.max(1, currentZoom - 0.5);
                zoomSlider.value = currentZoom;
                zoomLevel.textContent = Math.round(currentZoom * 100) + '%';
                updateImageTransform();
            }
        });

        // Mouse wheel zoom
        lightbox.addEventListener('wheel', function(e) {
            if (lightbox.classList.contains('active')) {
                e.preventDefault();
                const delta = e.deltaY > 0 ? -0.1 : 0.1;
                currentZoom = Math.max(1, Math.min(5, currentZoom + delta));
                zoomSlider.value = currentZoom;
                zoomLevel.textContent = Math.round(currentZoom * 100) + '%';
                updateImageTransform();
            }
        });

        // Drag to pan
        lightboxImage.addEventListener('mousedown', function(e) {
            if (currentZoom > 1) {
                isDragging = true;
                startX = e.clientX - translateX;
                startY = e.clientY - translateY;
                lightboxImage.style.cursor = 'grabbing';
                lightboxImage.style.transition = 'none';
            }
        });

        document.addEventListener('mousemove', function(e) {
            if (isDragging) {
                translateX = e.clientX - startX;
                translateY = e.clientY - startY;
                updateImageTransform();
            }
        });

        document.addEventListener('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                lightboxImage.style.cursor = 'grab';
                lightboxImage.style.transition = 'transform 0.3s ease';
            }
        });

        // Close lightbox
        lightboxClose.addEventListener('click', function() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
            resetZoom();
        });

        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
                resetZoom();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
                resetZoom();
            }
        });

        // Initial setup
        setupLightbox();

        // Re-setup after Livewire navigation
        document.addEventListener('livewire:navigated', function() {
            setTimeout(setupLightbox, 100);
        });
    });
</script>
</body>
</html>
