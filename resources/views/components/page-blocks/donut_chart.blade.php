{{-- Donut Chart Block (simple / multi) --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
    $donutStyle = $data['donut_style'] ?? 'simple';
    $animate = $data['animate'] ?? true;
    $title = $data['title'] ?? '';
    $unit = $data['unit'] ?? '';
    $inGroup = $inGroup ?? false;
    $donutWidth = $inGroup ? '100%' : (($data['donut_width'] ?? '100') . '%');

    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '', 'small' => 'mt-2', 'normal' => 'mt-4', 'medium' => 'mt-6',
        'large' => 'mt-8', 'xl' => 'mt-12', '2xl' => 'mt-16', '3xl' => 'mt-24', default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '', 'small' => 'mb-2', 'normal' => 'mb-4', 'medium' => 'mb-6',
        'large' => 'mb-8', 'xl' => 'mb-12', '2xl' => 'mb-16', '3xl' => 'mb-24', default => 'mb-12',
    };

    $donutSizeKey = $data['donut_size'] ?? 'md';
    $sizeMapSimple = [
        'xs' => ['svg' => 100, 'r' => 38,  'stroke' => 8,  'valClass' => 'text-xl'],
        'sm' => ['svg' => 140, 'r' => 55,  'stroke' => 9,  'valClass' => 'text-2xl'],
        'md' => ['svg' => 180, 'r' => 75,  'stroke' => 10, 'valClass' => 'text-[40px]'],
        'lg' => ['svg' => 220, 'r' => 90,  'stroke' => 12, 'valClass' => 'text-5xl'],
        'xl' => ['svg' => 280, 'r' => 115, 'stroke' => 14, 'valClass' => 'text-6xl'],
    ];
    $sizeMapMulti = [
        'xs' => ['svg' => 160, 'r' => 55,  'stroke' => 20],
        'sm' => ['svg' => 200, 'r' => 70,  'stroke' => 24],
        'md' => ['svg' => 280, 'r' => 105, 'stroke' => 32],
        'lg' => ['svg' => 340, 'r' => 130, 'stroke' => 36],
        'xl' => ['svg' => 400, 'r' => 155, 'stroke' => 40],
    ];

    $ringColorMap = [
        'text-blue-300' => '#0C4EBB', 'text-blue-400' => '#2196F3',
        'text-blue-500' => '#005A99', 'text-blue-600' => '#00355A',
        'text-green-300' => '#009688', 'text-grey' => '#999999',
        'text-black-500' => '#1A2B3D', 'text-white' => '#CCCCCC',
    ];

    $defaultSegmentColors = ['#005B9C', '#2196F3', '#00BCD4', '#4FC3F7', '#B3E5FC', '#009688', '#80CBC4'];
@endphp

{{-- ============ SIMPLE DONUT ============ --}}
@if($donutStyle === 'simple')
    @php
        $sc = $sizeMapSimple[$donutSizeKey] ?? $sizeMapSimple['md'];
        $svgSize = $sc['svg']; $radius = $sc['r']; $strokeWidth = $sc['stroke'];
        $cx = $svgSize / 2; $cy = $svgSize / 2;
        $circumference = round(2 * M_PI * $radius, 2);
        $percentage = min(100, max(0, (float) str_replace(',', '.', $data['value'] ?? '0')));
        $dashoffset = round($circumference - ($circumference * $percentage / 100), 2);
        $ringHexColor = $ringColorMap[$data['ring_color'] ?? 'text-blue-400'] ?? '#2196F3';
        $prefix = $data['prefix'] ?? ''; $suffix = $data['suffix'] ?? '%';
        $description = $data['description'] ?? '';
        $numericValue = (float) str_replace(',', '.', $data['value'] ?? '0');

        // Center text size override
        $centerTextSize = $data['center_text_size'] ?? 'auto';
        $centerFontSizeMap = [
            'md' => '24px', 'lg' => '32px', 'xl' => '40px', '2xl' => '48px', '3xl' => '60px',
        ];
        $centerFontStyle = ($centerTextSize !== 'auto' && isset($centerFontSizeMap[$centerTextSize]))
            ? 'font-size: ' . $centerFontSizeMap[$centerTextSize]
            : '';
        $centerValClass = ($centerTextSize !== 'auto' && isset($centerFontSizeMap[$centerTextSize]))
            ? '' : $sc['valClass'];
    @endphp

    <div
        id="{{ $blockId }}"
        class="page-block page-block--donut-chart flex flex-col items-center {{ $spacingTop }} {{ $spacingBottom }}"
        style="max-width: {{ $donutWidth }}"
        x-data="{ shown: false, displayValue: '{{ $prefix }}0{{ $suffix }}' }"
        x-init="
            const observer = new IntersectionObserver(([entry]) => {
                if (entry.isIntersecting) {
                    shown = true;
                    observer.unobserve($el);
                    @if($animate)
                    const target = {{ $numericValue }};
                    const duration = 1500; const start = performance.now();
                    const isInt = target === Math.floor(target);
                    const pfx = '{{ $prefix }}'; const sfx = '{{ $suffix }}';
                    const tick = (now) => {
                        const elapsed = now - start;
                        const progress = Math.min(elapsed / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        const current = eased * target;
                        const display = isInt ? Math.round(current) : current.toFixed(1).replace('.', ',');
                        displayValue = pfx + display + sfx;
                        if (progress < 1) requestAnimationFrame(tick);
                    };
                    requestAnimationFrame(tick);
                    @endif
                }
            }, { threshold: 0.3 });
            observer.observe($el);
        "
    >
        @if(trim(strip_tags($title)) !== '')
            <h3 class="text-2xl text-blue-500 font-normal mb-2" style="text-align: center">{!! str_replace(['<p>', '</p>'], '', $title) !!}</h3>
        @endif
        @if(trim(strip_tags($unit)) !== '')
            <p class="text-lg leading-6 text-black-500 mb-4" style="text-align: center">{!! str_replace(['<p>', '</p>'], '', $unit) !!}</p>
        @endif

        <div class="relative" style="width: {{ $svgSize }}px; height: {{ $svgSize }}px">
            <svg class="w-full h-full" viewBox="0 0 {{ $svgSize }} {{ $svgSize }}" style="transform: rotate(-90deg)">
                <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}" fill="none" stroke="#E8EEF4" stroke-width="{{ $strokeWidth }}"/>
                <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}" fill="none"
                    stroke="{{ $ringHexColor }}" stroke-width="{{ $strokeWidth }}" stroke-linecap="round"
                    :stroke-dasharray="shown ? '{{ $circumference - $dashoffset }} {{ $dashoffset }}' : '0 {{ $circumference }}'"
                    style="transition: stroke-dasharray 1.5s cubic-bezier(0.25, 1, 0.5, 1)"
                />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center" style="transform: none">
                <div class="{{ $centerValClass }} font-extrabold text-[#00355A] leading-none" style="{{ $centerFontStyle }}" x-text="displayValue"></div>
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
        $svgSize = $mc['svg']; $radius = $mc['r']; $strokeWidth = $mc['stroke'];
        $cx = $svgSize / 2; $cy = $svgSize / 2;
        $circumference = round(2 * M_PI * $radius, 2);

        $segments = $data['segments'] ?? [];
        $centerValue = $data['center_value'] ?? '';
        $centerLabel = $data['center_label'] ?? '';
        $centerImageRaw = $data['center_image'] ?? $data['center_image_url'] ?? '';
        $centerImageUrl = '';
        if ($centerImageRaw) {
            $centerImageUrl = str_starts_with($centerImageRaw, 'http') ? $centerImageRaw : Storage::url($centerImageRaw);
        }

        $total = 0;
        foreach ($segments as $seg) { $total += (float) str_replace(',', '.', $seg['value'] ?? '0'); }

        $cumulativePercent = 0;
        $segmentData = [];
        foreach ($segments as $i => $seg) {
            $segValue = (float) str_replace(',', '.', $seg['value'] ?? '0');
            $percent = $total > 0 ? ($segValue / $total * 100) : 0;
            $color = $seg['color'] ?? ($defaultSegmentColors[$i % count($defaultSegmentColors)]);
            $segmentData[] = [
                'label' => $seg['label'] ?? '', 'value' => $seg['value'] ?? '0',
                'percent' => round($percent, 2), 'offset' => round($cumulativePercent, 2), 'color' => $color,
            ];
            $cumulativePercent += $percent;
        }

        $uid = 'md' . substr(md5($blockId), 0, 8);
    @endphp

    <div
        id="{{ $blockId }}"
        class="page-block page-block--donut-chart {{ $spacingTop }} {{ $spacingBottom }}"
        style="max-width: {{ $donutWidth }}"
        x-data="{ shown: false, hovered: false, centerVal: '', centerLbl: '' }"
        x-init="
            centerVal = '{{ str_replace("'", "\\'", $centerValue) }}';
            centerLbl = '{{ str_replace("'", "\\'", $centerLabel) }}';
            const circ = {{ $circumference }};
            const observer = new IntersectionObserver(([entry]) => {
                if (entry.isIntersecting) {
                    shown = true;
                    observer.unobserve($el);
                    $el.querySelectorAll('.{{ $uid }}-seg').forEach(seg => {
                        const pct = parseFloat(seg.dataset.percent);
                        seg.style.transition = 'none';
                        seg.style.strokeDasharray = '0 ' + circ;
                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => {
                                seg.style.transition = 'stroke-dasharray 1.5s cubic-bezier(0.25, 1, 0.5, 1)';
                                seg.style.strokeDasharray = (circ * pct / 100) + ' ' + circ;
                            });
                        });
                    });
                }
            }, { threshold: 0.25 });
            observer.observe($el);
        "
    >
        @if(trim(strip_tags($title)) !== '')
            <h3 class="text-2xl text-blue-500 font-normal mb-2">{!! str_replace(['<p>', '</p>'], '', $title) !!}</h3>
        @endif
        @if(trim(strip_tags($unit)) !== '')
            <p class="text-lg leading-6 text-black-500 mb-5">{!! str_replace(['<p>', '</p>'], '', $unit) !!}</p>
        @endif

        <div class="flex items-center gap-6 md:flex-col">
            <div class="relative shrink-0 {{ $uid }}-wrap" style="width: {{ $svgSize }}px; height: {{ $svgSize }}px">
                <svg class="w-full h-full" viewBox="0 0 {{ $svgSize }} {{ $svgSize }}" style="transform: rotate(-90deg); overflow: visible">
                    <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}" fill="none" stroke="#E8EEF4" stroke-width="{{ $strokeWidth }}"/>

                    @foreach($segmentData as $i => $seg)
                        <circle class="{{ $uid }}-seg"
                            cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}"
                            fill="none" stroke="{{ $seg['color'] }}" stroke-width="{{ $strokeWidth }}"
                            stroke-linecap="butt"
                            stroke-dasharray="0 {{ $circumference }}"
                            stroke-dashoffset="{{ -$circumference * $seg['offset'] / 100 }}"
                            data-percent="{{ $seg['percent'] }}" data-index="{{ $i }}"
                            style="cursor: pointer"
                        />
                    @endforeach

                    @foreach($segmentData as $i => $seg)
                        <circle class="{{ $uid }}-hit"
                            cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $radius }}"
                            fill="none" stroke="transparent"
                            stroke-width="{{ $strokeWidth + 20 }}" stroke-linecap="butt"
                            stroke-dasharray="{{ $circumference * $seg['percent'] / 100 }} {{ $circumference }}"
                            stroke-dashoffset="{{ -$circumference * $seg['offset'] / 100 }}"
                            style="pointer-events: stroke; cursor: pointer" data-index="{{ $i }}"
                        />
                    @endforeach
                </svg>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none" style="padding: {{ round($radius * 0.25) }}px">
                    @if($centerImageUrl)
                        {{-- Icon: visible by default, hidden on hover --}}
                        <img src="{{ $centerImageUrl }}"
                             alt="" class="transition-all duration-300"
                             :class="shown && !hovered ? 'opacity-100 scale-100' : (hovered ? 'opacity-0 scale-90' : 'opacity-0 scale-90')"
                             style="max-width: {{ round(0.55 * ($radius - $strokeWidth / 2)) }}px; max-height: {{ round(0.55 * ($radius - $strokeWidth / 2)) }}px; object-fit: contain; position: absolute;"
                        />
                        {{-- Text: hidden by default, shown on hover --}}
                        <div class="flex flex-col items-center transition-all duration-300"
                             :class="hovered ? 'opacity-100 scale-100' : 'opacity-0 scale-90'"
                        >
                            <span class="font-extrabold text-[#00355A] break-words leading-tight"
                                style="font-size: {{ $svgSize >= 400 ? '32px' : ($svgSize >= 340 ? '26px' : ($svgSize >= 280 ? '20px' : ($svgSize >= 200 ? '15px' : '13px'))) }}; max-width: {{ round(1.3 * ($radius - $strokeWidth / 2)) }}px"
                                x-text="centerVal"></span>
                            <span x-show="centerLbl" class="text-[#6B7785] mt-1 font-medium break-words"
                                style="font-size: {{ $svgSize >= 400 ? '16px' : ($svgSize >= 340 ? '14px' : ($svgSize >= 280 ? '13px' : ($svgSize >= 200 ? '12px' : '11px'))) }}; max-width: {{ round(1.3 * ($radius - $strokeWidth / 2)) }}px; line-height: 1.2"
                                x-text="centerLbl"></span>
                        </div>
                    @else
                        <span class="font-extrabold text-[#00355A] transition-opacity duration-300 break-words leading-tight"
                            :class="shown ? 'opacity-100' : 'opacity-0'"
                            style="transition-delay: 0.6s; font-size: {{ $svgSize >= 400 ? '36px' : ($svgSize >= 340 ? '28px' : ($svgSize >= 280 ? '24px' : ($svgSize >= 200 ? '18px' : '14px'))) }}; max-width: {{ round(1.3 * ($radius - $strokeWidth / 2)) }}px"
                            x-text="centerVal"></span>
                        <span x-show="centerLbl" class="text-[#6B7785] mt-1 transition-opacity duration-300 font-medium break-words"
                            :class="shown ? 'opacity-100' : 'opacity-0'"
                            style="transition-delay: 0.8s; font-size: {{ $svgSize >= 400 ? '16px' : ($svgSize >= 340 ? '15px' : ($svgSize >= 280 ? '14px' : ($svgSize >= 200 ? '12px' : '11px'))) }}; max-width: {{ round(1.3 * ($radius - $strokeWidth / 2)) }}px; line-height: 1.2"
                            x-text="centerLbl"></span>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap-2.5 w-full max-w-[450px]">
                @foreach($segmentData as $i => $seg)
                    <div class="{{ $uid }}-leg flex items-center gap-3 py-2 px-3.5 rounded-[10px] transition-all duration-300 cursor-pointer"
                        style="border: 1px solid transparent"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'"
                        :style="'transition-delay: {{ 0.3 + $i * 0.1 }}s'"
                        data-index="{{ $i }}"
                        data-val="{{ str_replace('.', ',', $seg['value']) }}"
                        data-lbl="{{ $seg['label'] }}"
                    >
                        <div class="w-3.5 h-3.5 rounded-[4px] shrink-0 shadow-sm" style="background-color: {{ $seg['color'] }}"></div>
                        <span class="text-sm text-[#2D3E50] leading-snug">{{ $seg['label'] }}</span>
                        <span class="text-sm font-bold ml-auto pl-4 shrink-0" style="color: {{ $seg['color'] }}">{{ str_replace('.', ',', $seg['value']) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
    (function() {
        function initDonut() {
            var block = document.getElementById('{!! $blockId !!}');
            if (!block) return;
            var data;
            try { data = Alpine.$data(block); } catch(e) { return; }
            if (!data) return;

            var origV = {!! json_encode($centerValue) !!};
            var origL = {!! json_encode($centerLabel) !!};
            var segs = block.querySelectorAll('.{{ $uid }}-seg');
            var hits = block.querySelectorAll('.{{ $uid }}-hit');
            var legs = block.querySelectorAll('.{{ $uid }}-leg');
            var sw = {{ $strokeWidth }};
            var swH = {{ $strokeWidth + 8 }};

            function hi(idx) {
                data.hovered = true;
                segs.forEach(function(s) {
                    if (s.dataset.index === idx) {
                        s.setAttribute('stroke-width', swH);
                        s.style.filter = 'drop-shadow(0 0 8px rgba(33,150,243,0.4)) brightness(1.1)';
                    }
                });
                legs.forEach(function(l) {
                    if (l.dataset.index === idx) {
                        l.style.background = 'rgba(33,150,243,0.06)';
                        l.style.borderColor = '#E8EEF4';
                        l.style.boxShadow = '0 2px 8px rgba(0,0,0,0.04)';
                        data.centerVal = l.dataset.val;
                        data.centerLbl = l.dataset.lbl;
                    }
                });
            }

            function lo() {
                segs.forEach(function(s) { s.setAttribute('stroke-width', sw); s.style.filter = ''; });
                legs.forEach(function(l) { l.style.background = ''; l.style.borderColor = 'transparent'; l.style.boxShadow = ''; });
                data.centerVal = origV;
                data.centerLbl = origL;
                data.hovered = false;
            }

            segs.forEach(function(s) { s.addEventListener('mouseenter', function() { hi(s.dataset.index); }); s.addEventListener('mouseleave', lo); });
            hits.forEach(function(h) { h.addEventListener('mouseenter', function() { hi(h.dataset.index); }); h.addEventListener('mouseleave', lo); });
            legs.forEach(function(l) { l.addEventListener('mouseenter', function() { hi(l.dataset.index); }); l.addEventListener('mouseleave', lo); });
        }

        // Wait for Alpine to be ready
        if (window.Alpine) {
            // Alpine loaded — wait a tick for component init
            setTimeout(initDonut, 50);
        } else {
            document.addEventListener('alpine:init', function() {
                setTimeout(initDonut, 50);
            });
        }
        // Fallback
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initDonut, 200);
        });
    })();
    </script>
@endif
