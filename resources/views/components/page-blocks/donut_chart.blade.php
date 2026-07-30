{{-- Donut Chart Block (simple / multi) --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
    $donutStyle = $data['donut_style'] ?? 'simple';
    $animate = $data['animate'] ?? true;

    // Spacing
    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '', 'small' => 'mt-2', 'normal' => 'mt-4', 'medium' => 'mt-6',
        'large' => 'mt-8', 'xl' => 'mt-12', '2xl' => 'mt-16', '3xl' => 'mt-24', default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '', 'small' => 'mb-2', 'normal' => 'mb-4', 'medium' => 'mb-6',
        'large' => 'mb-8', 'xl' => 'mb-12', '2xl' => 'mb-16', '3xl' => 'mb-24', default => 'mb-12',
    };

    // Donut size config
    $donutSizeKey = $data['donut_size'] ?? 'md';
    $sizeMapSimple = [
        'xs' => ['svg' => 100, 'r' => 38,  'stroke' => 8,  'valClass' => 'text-xl',   'unitClass' => 'text-xs'],
        'sm' => ['svg' => 140, 'r' => 55,  'stroke' => 9,  'valClass' => 'text-2xl',  'unitClass' => 'text-sm'],
        'md' => ['svg' => 180, 'r' => 75,  'stroke' => 10, 'valClass' => 'text-[40px]','unitClass' => 'text-lg'],
        'lg' => ['svg' => 220, 'r' => 90,  'stroke' => 12, 'valClass' => 'text-5xl',  'unitClass' => 'text-xl'],
        'xl' => ['svg' => 280, 'r' => 115, 'stroke' => 14, 'valClass' => 'text-6xl',  'unitClass' => 'text-2xl'],
    ];
    $sizeMapMulti = [
        'xs' => ['svg' => 160, 'r' => 55,  'stroke' => 20],
        'sm' => ['svg' => 200, 'r' => 70,  'stroke' => 24],
        'md' => ['svg' => 280, 'r' => 105, 'stroke' => 32],
        'lg' => ['svg' => 340, 'r' => 130, 'stroke' => 36],
        'xl' => ['svg' => 400, 'r' => 155, 'stroke' => 40],
    ];

    // Ring color map (Tailwind class => hex)
    $ringColorMap = [
        'text-blue-300' => '#0C4EBB',
        'text-blue-400' => '#2196F3',
        'text-blue-500' => '#005A99',
        'text-blue-600' => '#00355A',
        'text-green-300' => '#009688',
        'text-grey' => '#999999',
        'text-black-500' => '#1A2B3D',
        'text-white' => '#CCCCCC',
    ];

    // Default chart segment colors
    $defaultSegmentColors = ['#005B9C', '#2196F3', '#00BCD4', '#4FC3F7', '#B3E5FC', '#009688', '#80CBC4'];
@endphp

{{-- ============ SIMPLE DONUT ============ --}}
@if($donutStyle === 'simple')
    @php
        $sc = $sizeMapSimple[$donutSizeKey] ?? $sizeMapSimple['md'];
        $svgSize = $sc['svg'];
        $radius = $sc['r'];
        $strokeWidth = $sc['stroke'];
        $cx = $svgSize / 2;
        $cy = $svgSize / 2;
        $circumference = round(2 * M_PI * $radius, 2);
        $percentage = min(100, max(0, (float) str_replace(',', '.', $data['value'] ?? '0')));
        $dashoffset = round($circumference - ($circumference * $percentage / 100), 2);
        $ringHexColor = $ringColorMap[$data['ring_color'] ?? 'text-blue-400'] ?? '#2196F3';

        $prefix = $data['prefix'] ?? '';
        $suffix = $data['suffix'] ?? '%';
        $description = $data['description'] ?? '';
        $numericValue = (float) str_replace(',', '.', $data['value'] ?? '0');

        $uniqueId = 'donut-' . $blockId;
    @endphp

    <div
        id="{{ $blockId }}"
        class="page-block page-block--donut-chart flex flex-col items-center {{ $spacingTop }} {{ $spacingBottom }}"
        x-data="{ shown: false, displayValue: '{{ $prefix }}0{{ $suffix }}' }"
        x-init="
            const observer = new IntersectionObserver(([entry]) => {
                if (entry.isIntersecting) {
                    shown = true;
                    observer.unobserve($el);
                    // Animate ring
                    const ring = $el.querySelector('.donut-fill-ring');
                    if (ring) ring.style.strokeDashoffset = '{{ $dashoffset }}';
                    // Animate counter
                    const target = {{ $numericValue }};
                    const start = performance.now();
                    const duration = 1800;
                    const tick = (now) => {
                        const progress = Math.min((now - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        const current = Math.floor(target * eased);
                        displayValue = '{{ $prefix }}' + current + '{{ $suffix }}';
                        if (progress < 1) requestAnimationFrame(tick);
                        else displayValue = '{{ $prefix }}' + target + '{{ $suffix }}';
                    };
                    requestAnimationFrame(tick);
                }
            }, { threshold: 0.25 });
            observer.observe($el);
        "
    >
        <div class="relative" style="width: {{ $svgSize }}px; height: {{ $svgSize }}px">
            <svg class="w-full h-full" viewBox="0 0 {{ $svgSize }} {{ $svgSize }}" style="transform: rotate(-90deg)">
                {{-- Background ring --}}
                <circle
                    cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}"
                    fill="none" stroke="#E8EEF4" stroke-width="{{ $strokeWidth }}"
                />
                {{-- Value ring --}}
                <circle
                    class="donut-fill-ring"
                    cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}"
                    fill="none" stroke="{{ $ringHexColor }}" stroke-width="{{ $strokeWidth }}"
                    stroke-linecap="round"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ $circumference }}"
                    style="transition: stroke-dashoffset 2s cubic-bezier(0.25, 1, 0.5, 1)"
                />
            </svg>

            {{-- Center text --}}
            <div class="absolute inset-0 flex flex-col items-center justify-center" style="transform: none">
                <div class="{{ $sc['valClass'] }} font-extrabold text-[#00355A] leading-none" x-text="displayValue"></div>
            </div>
        </div>

        @if($description)
            <p class="mt-4 text-sm text-[#4A5568] text-center font-medium max-w-[220px]">{{ $description }}</p>
        @endif
    </div>

{{-- ============ MULTI-SEGMENT DONUT ============ --}}
@elseif($donutStyle === 'multi')
    @php
        $mc = $sizeMapMulti[$donutSizeKey] ?? $sizeMapMulti['md'];
        $svgSize = $mc['svg'];
        $radius = $mc['r'];
        $strokeWidth = $mc['stroke'];
        $cx = $svgSize / 2;
        $cy = $svgSize / 2;
        $circumference = round(2 * M_PI * $radius, 2);

        $segments = $data['segments'] ?? [];
        $centerValue = $data['center_value'] ?? '';
        $centerLabel = $data['center_label'] ?? '';

        // Parse segment values
        $total = 0;
        foreach ($segments as $seg) {
            $total += (float) str_replace(',', '.', $seg['value'] ?? '0');
        }

        // Compute segment arcs
        $cumulativePercent = 0;
        $segmentData = [];
        foreach ($segments as $i => $seg) {
            $segValue = (float) str_replace(',', '.', $seg['value'] ?? '0');
            $percent = $total > 0 ? ($segValue / $total * 100) : 0;
            $color = $seg['color'] ?? ($defaultSegmentColors[$i % count($defaultSegmentColors)]);

            $segmentData[] = [
                'label' => $seg['label'] ?? '',
                'value' => $seg['value'] ?? '0',
                'percent' => round($percent, 2),
                'offset' => round($cumulativePercent, 2),
                'color' => $color,
            ];

            $cumulativePercent += $percent;
        }

        $uniqueId = 'multi-donut-' . $blockId;
    @endphp

    <div
        id="{{ $blockId }}"
        class="page-block page-block--donut-chart flex items-center gap-[60px] md:flex-col {{ $spacingTop }} {{ $spacingBottom }}"
        x-data="{ shown: false }"
        x-init="
            const observer = new IntersectionObserver(([entry]) => {
                if (entry.isIntersecting) {
                    shown = true;
                    observer.unobserve($el);
                    // Animate segments
                    $el.querySelectorAll('.multi-seg').forEach(seg => {
                        const pct = parseFloat(seg.dataset.percent);
                        const offset = parseFloat(seg.dataset.offset);
                        const circ = {{ $circumference }};
                        seg.style.transition = 'none';
                        seg.style.strokeDasharray = `0 ${circ}`;
                        seg.style.strokeDashoffset = -circ * offset / 100;
                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => {
                                seg.style.transition = 'stroke-dasharray 1.5s cubic-bezier(0.25, 1, 0.5, 1)';
                                seg.style.strokeDasharray = `${circ * pct / 100} ${circ}`;
                            });
                        });
                    });
                }
            }, { threshold: 0.25 });
            observer.observe($el);
        "
    >
        {{-- SVG Donut --}}
        <div class="relative shrink-0 donut-multi-{{ $blockId }}" style="width: {{ $svgSize }}px; height: {{ $svgSize }}px">
            <svg class="w-full h-full" viewBox="0 0 {{ $svgSize }} {{ $svgSize }}" style="transform: rotate(-90deg); overflow: visible">
                {{-- Background ring --}}
                <circle
                    cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}"
                    fill="none" stroke="#E8EEF4" stroke-width="{{ $strokeWidth }}"
                />

                {{-- Segments --}}
                @foreach($segmentData as $i => $seg)
                    <circle
                        class="multi-seg"
                        cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}"
                        fill="none"
                        stroke="{{ $seg['color'] }}"
                        stroke-width="{{ $strokeWidth }}"
                        stroke-linecap="butt"
                        stroke-dasharray="0 {{ $circumference }}"
                        stroke-dashoffset="{{ -$circumference * $seg['offset'] / 100 }}"
                        data-percent="{{ $seg['percent'] }}"
                        data-offset="{{ $seg['offset'] }}"
                        data-index="{{ $i }}"
                    />
                @endforeach
            </svg>

            {{-- Center text --}}
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span
                    class="font-extrabold text-[#00355A] leading-none transition-all duration-300"
                    :class="shown ? 'opacity-100' : 'opacity-0'"
                    style="transition-delay: 0.6s; font-size: {{ $svgSize >= 280 ? '32px' : ($svgSize >= 200 ? '24px' : '18px') }}"
                    id="donut-cv-{{ $blockId }}"
                >{{ $centerValue }}</span>
                @if($centerLabel)
                    <span
                        class="text-[#6B7785] mt-1 transition-all duration-300"
                        :class="shown ? 'opacity-100' : 'opacity-0'"
                        style="transition-delay: 0.8s; font-size: {{ $svgSize >= 280 ? '13px' : '11px' }}"
                        id="donut-cl-{{ $blockId }}"
                    >{{ $centerLabel }}</span>
                @endif
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex flex-col gap-3">
            @foreach($segmentData as $i => $seg)
                <div
                    class="donut-leg-{{ $blockId }} flex items-center gap-3 py-[10px] px-4 rounded-[10px] transition-all duration-300 cursor-pointer"
                    style="border: 1px solid transparent"
                    :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'"
                    :style="'transition-delay: {{ 0.3 + $i * 0.1 }}s'"
                    data-seg-index="{{ $i }}"
                    data-seg-label="{{ $seg['label'] }}"
                    data-seg-value="{{ str_replace('.', ',', $seg['value']) }}"
                >
                    <div class="w-[14px] h-[14px] rounded-[4px] shrink-0" style="background-color: {{ $seg['color'] }}"></div>
                    <span class="text-sm text-[#2D3E50]">{{ $seg['label'] }}</span>
                    <span class="text-sm font-bold text-[#00355A] ml-auto pl-4">{{ str_replace('.', ',', $seg['value']) }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .donut-multi-{{ $blockId }} .multi-seg {
            cursor: pointer;
            transition: stroke-width 0.3s ease, filter 0.3s ease, stroke-dasharray 1.5s cubic-bezier(0.25, 1, 0.5, 1);
            transform-origin: center;
        }
        .donut-multi-{{ $blockId }} .multi-seg:hover {
            stroke-width: {{ $strokeWidth + 8 }};
            filter: drop-shadow(0 0 8px rgba(33,150,243,0.4)) brightness(1.1);
        }
        .donut-leg-{{ $blockId }}:hover {
            background: rgba(33,150,243,0.06);
            border-color: #E8EEF4 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrap = document.querySelector('.donut-multi-{{ $blockId }}');
            if (!wrap) return;
            const segs = wrap.querySelectorAll('.multi-seg');
            const cv = document.getElementById('donut-cv-{{ $blockId }}');
            const cl = document.getElementById('donut-cl-{{ $blockId }}');
            const origV = {!! json_encode($centerValue) !!};
            const origL = {!! json_encode($centerLabel) !!};
            const parent = wrap.closest('.page-block--donut-chart');
            const legs = parent ? parent.querySelectorAll('.donut-leg-{{ $blockId }}') : [];

            segs.forEach(seg => {
                seg.addEventListener('mouseenter', () => {
                    const idx = seg.dataset.index;
                    const li = parent ? parent.querySelector('.donut-leg-{{ $blockId }}[data-seg-index="' + idx + '"]') : null;
                    if (li && cv) { cv.textContent = li.dataset.segValue; }
                    if (li && cl) { cl.textContent = li.dataset.segLabel; }
                });
                seg.addEventListener('mouseleave', () => {
                    if (cv) cv.textContent = origV;
                    if (cl) cl.textContent = origL;
                });
            });

            legs.forEach(li => {
                li.addEventListener('mouseenter', () => {
                    const idx = li.dataset.segIndex;
                    segs.forEach(s => {
                        if (s.dataset.index === idx) {
                            s.style.strokeWidth = '{{ $strokeWidth + 8 }}';
                            s.style.filter = 'drop-shadow(0 0 8px rgba(33,150,243,0.4)) brightness(1.1)';
                        }
                    });
                    if (cv) cv.textContent = li.dataset.segValue;
                    if (cl) cl.textContent = li.dataset.segLabel;
                });
                li.addEventListener('mouseleave', () => {
                    segs.forEach(s => { s.style.strokeWidth = ''; s.style.filter = ''; });
                    if (cv) cv.textContent = origV;
                    if (cl) cl.textContent = origL;
                });
            });
        });
    </script>
@endif
