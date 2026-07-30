{{-- Chart Block (lollipop / bar / line) — styled to match charts-lollipop-demo.html --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
    $chartType = $data['chart_type'] ?? 'lollipop';
    $animate = $data['animate'] ?? true;
    $title = $data['title'] ?? '';
    $unit = $data['unit'] ?? '';
    $values = $data['values'] ?? [];
    $numValues = count($values);

    // Parse numeric values (primary + optional secondary)
    $numericValues = array_map(fn($v) => (float) str_replace(',', '.', $v['value'] ?? '0'), $values);
    $numericValues2 = array_map(fn($v) => (float) str_replace(',', '.', $v['value2'] ?? '0'), $values);
    $hasSecondValue = !empty(array_filter($numericValues2, fn($v) => $v > 0));

    $allValues = $hasSecondValue ? array_merge($numericValues, array_filter($numericValues2, fn($v) => $v > 0)) : $numericValues;
    $maxValue = !empty($allValues) ? max($allValues) : 1;
    $minValue = !empty($allValues) ? min($allValues) : 0;

    // Color scheme
    $colorScheme = $data['color_scheme'] ?? 'blue';
    $colorMap = [
        'blue'       => ['main' => '#5BA4D9', 'dark' => '#005B9C', 'light' => '#B8D4EA', 'text' => '#005B9C', 'border' => '#5BA4D9'],
        'dark_blue'  => ['main' => '#005B9C', 'dark' => '#00355A', 'light' => '#A5CBE5', 'text' => '#00355A', 'border' => '#005B9C'],
        'cyan'       => ['main' => '#00BCD4', 'dark' => '#00838F', 'light' => '#B2EBF2', 'text' => '#00838F', 'border' => '#00BCD4'],
        'teal'       => ['main' => '#4DB6AC', 'dark' => '#009688', 'light' => '#B2DFDB', 'text' => '#009688', 'border' => '#4DB6AC'],
        'light_blue' => ['main' => '#4FC3F7', 'dark' => '#039BE5', 'light' => '#B3E5FC', 'text' => '#0277BD', 'border' => '#4FC3F7'],
        'grey'       => ['main' => '#90A4AE', 'dark' => '#6B7785', 'light' => '#CFD8DC', 'text' => '#546E7A', 'border' => '#90A4AE'],
    ];
    $cc = $colorMap[$colorScheme] ?? $colorMap['blue'];

    // Spacing
    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '', 'small' => 'mt-2', 'normal' => 'mt-4', 'medium' => 'mt-6',
        'large' => 'mt-8', 'xl' => 'mt-12', '2xl' => 'mt-16', '3xl' => 'mt-24', default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '', 'small' => 'mb-2', 'normal' => 'mb-4', 'medium' => 'mb-6',
        'large' => 'mb-8', 'xl' => 'mb-12', '2xl' => 'mb-16', '3xl' => 'mb-24', default => 'mb-12',
    };

    // Chart area height
    $chartSizeKey = $data['chart_size'] ?? 'medium';
    $chartHeight = match($chartSizeKey) {
        'compact' => 140,
        'small' => 180,
        'medium' => 220,
        'large' => 280,
        'xl' => 340,
        default => 220,
    };

    // Format value for display
    if (!function_exists('formatChartValue')) {
        function formatChartValue($val) {
            $float = (float) str_replace(',', '.', $val);
            if ($float == (int) $float) {
                return number_format($float, 0, ',', ' ');
            }
            return str_replace('.', ',', $val);
        }
    }

    // Unique scoped class
    $scopeClass = 'chart-' . md5($blockId);
@endphp

<div
    id="{{ $blockId }}"
    class="page-block page-block--chart {{ $spacingTop }} {{ $spacingBottom }}"
>
    {{-- Header --}}
    @if($title)
        <div style="font-size: 13px; font-weight: 700; color: #00355A; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 4px">{{ $title }}</div>
    @endif
    @if($unit)
        <div style="font-size: 12px; color: #6B7785; margin-bottom: 24px">{{ $unit }}</div>
    @endif

    {{-- ============ LOLLIPOP CHART ============ --}}
    @if($chartType === 'lollipop')
        <div
            class="{{ $scopeClass }}"
            x-data="{ shown: false }"
            x-init="
                const observer = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    shown = true;
                    observer.unobserve($el);
                    const items = $el.querySelectorAll('.lolli-item');
                    const chartH = {{ $chartHeight }} - 40;
                    items.forEach((item, i) => {
                        const pct = parseFloat(item.dataset.heightPct) / 100;
                        const stem = item.querySelector('.lolli-stem');
                        const stem2 = item.querySelector('.lolli-stem-2');
                        setTimeout(() => {
                            if (stem) stem.style.height = (chartH * pct) + 'px';
                            item.classList.add('animated');
                        }, i * 200);
                        if (stem2) {
                            const pct2 = parseFloat(item.dataset.heightPct2) / 100;
                            setTimeout(() => {
                                stem2.style.height = (chartH * pct2) + 'px';
                            }, i * 200 + 100);
                        }
                    });
                }, { threshold: 0.3 });
                observer.observe($el);
            "
            style="display: flex; align-items: flex-end; justify-content: space-around; height: {{ $chartHeight }}px; position: relative; border-bottom: 2px solid #D6E4F0; padding: 0 20px"
        >
            @foreach($values as $i => $item)
                @php
                    $val = $numericValues[$i];
                    $heightPct = $maxValue > 0 ? round(($val / $maxValue) * 90, 1) : 0;
                    $displayVal = formatChartValue($item['value'] ?? '0');
                    $val2 = $numericValues2[$i] ?? 0;
                    $heightPct2 = ($hasSecondValue && $maxValue > 0) ? round(($val2 / $maxValue) * 90, 1) : 0;
                    $displayVal2 = $hasSecondValue ? formatChartValue($item['value2'] ?? '0') : '';
                @endphp
                <div
                    class="lolli-item"
                    data-height-pct="{{ $heightPct }}"
                    @if($hasSecondValue) data-height-pct2="{{ $heightPct2 }}" @endif
                    style="display: flex; flex-direction: column; align-items: center; position: relative; flex: 1; max-width: 120px"
                >
                    <div style="display: flex; align-items: flex-end; gap: {{ $hasSecondValue ? '8px' : '0' }}">
                        {{-- Primary --}}
                        <div style="display: flex; flex-direction: column; align-items: center">
                            <div class="lolli-val" style="font-size: 18px; font-weight: 700; color: {{ $cc['text'] }}; margin-bottom: 8px; white-space: nowrap; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease, transform 0.5s ease">{{ $displayVal }}</div>
                            <div class="lolli-dot" style="width: 18px; height: 18px; border-radius: 50%; background: #fff; border: 3px solid {{ $cc['border'] }}; position: relative; z-index: 2; transform: scale(0); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); flex-shrink: 0"></div>
                            <div class="lolli-stem" style="width: 3px; background: linear-gradient(to top, {{ $cc['light'] }}, {{ $cc['main'] }}); border-radius: 3px 3px 0 0; height: 0; transition: height 1s cubic-bezier(0.25, 1, 0.5, 1)"></div>
                        </div>
                        {{-- Secondary --}}
                        @if($hasSecondValue && $val2 > 0)
                            <div style="display: flex; flex-direction: column; align-items: center">
                                <div class="lolli-val" style="font-size: 16px; font-weight: 700; color: {{ $cc['light'] }}; margin-bottom: 8px; white-space: nowrap; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.1s, transform 0.5s ease 0.1s">{{ $displayVal2 }}</div>
                                <div class="lolli-dot" style="width: 16px; height: 16px; border-radius: 50%; background: #fff; border: 3px solid {{ $cc['light'] }}; position: relative; z-index: 2; transform: scale(0); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s; flex-shrink: 0"></div>
                                <div class="lolli-stem-2" style="width: 3px; background: linear-gradient(to top, #E8EEF4, {{ $cc['light'] }}); border-radius: 3px 3px 0 0; height: 0; transition: height 1s cubic-bezier(0.25, 1, 0.5, 1)"></div>
                            </div>
                        @endif
                    </div>
                    <div style="position: absolute; bottom: -28px; font-size: 13px; font-weight: 600; color: #6B7785">{{ $item['label'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
        <div style="height: 32px"></div>
        <style>
            .{{ $scopeClass }} .lolli-item.animated .lolli-val { opacity: 1 !important; transform: translateY(0) !important; }
            .{{ $scopeClass }} .lolli-item.animated .lolli-dot { transform: scale(1) !important; }
        </style>

    {{-- ============ BAR CHART ============ --}}
    @elseif($chartType === 'bar')
        <div
            class="{{ $scopeClass }}"
            x-data="{ shown: false }"
            x-init="
                const observer = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    shown = true;
                    observer.unobserve($el);
                    const items = $el.querySelectorAll('.bar-item-el');
                    const chartH = {{ $chartHeight }} - 10;
                    items.forEach((item, i) => {
                        const pct = parseFloat(item.dataset.heightPct) / 100;
                        const col = item.querySelector('.bar-col');
                        const col2 = item.querySelector('.bar-col-2');
                        setTimeout(() => {
                            if (col) col.style.height = (chartH * pct) + 'px';
                            item.classList.add('animated');
                        }, i * 200);
                        if (col2) {
                            const pct2 = parseFloat(item.dataset.heightPct2) / 100;
                            setTimeout(() => {
                                col2.style.height = (chartH * pct2) + 'px';
                            }, i * 200 + 100);
                        }
                    });
                }, { threshold: 0.3 });
                observer.observe($el);
            "
            style="display: flex; align-items: flex-end; justify-content: space-around; height: {{ $chartHeight }}px; position: relative; border-bottom: 2px solid #D6E4F0; padding: 0 10px"
        >
            @foreach($values as $i => $item)
                @php
                    $val = $numericValues[$i];
                    $heightPct = $maxValue > 0 ? round(($val / $maxValue) * 90, 1) : 0;
                    $displayVal = formatChartValue($item['value'] ?? '0');
                    $val2 = $numericValues2[$i] ?? 0;
                    $heightPct2 = ($hasSecondValue && $maxValue > 0) ? round(($val2 / $maxValue) * 90, 1) : 0;
                    $displayVal2 = $hasSecondValue ? formatChartValue($item['value2'] ?? '0') : '';
                @endphp
                <div
                    class="bar-item-el"
                    data-height-pct="{{ $heightPct }}"
                    @if($hasSecondValue) data-height-pct2="{{ $heightPct2 }}" @endif
                    style="display: flex; flex-direction: column; align-items: center; flex: 1; max-width: 100px"
                >
                    <div style="display: flex; align-items: flex-end; gap: {{ $hasSecondValue ? '4px' : '0' }}">
                        {{-- Primary bar --}}
                        <div style="display: flex; flex-direction: column; align-items: center">
                            <div class="bar-val" style="font-size: 16px; font-weight: 700; color: {{ $cc['text'] }}; margin-bottom: 8px; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.8s, transform 0.5s ease 0.8s">{{ $displayVal }}</div>
                            <div class="bar-col" style="width: {{ $hasSecondValue ? '32px' : '48px' }}; border-radius: 8px 8px 0 0; background: linear-gradient(to top, {{ $cc['light'] }}, {{ $cc['main'] }}); height: 0; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1); position: relative; cursor: pointer"
                                 onmouseenter="this.style.filter='brightness(1.1)'" onmouseleave="this.style.filter='none'"></div>
                        </div>
                        {{-- Secondary bar --}}
                        @if($hasSecondValue && $val2 > 0)
                            <div style="display: flex; flex-direction: column; align-items: center">
                                <div class="bar-val" style="font-size: 14px; font-weight: 700; color: {{ $cc['light'] }}; margin-bottom: 8px; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.9s, transform 0.5s ease 0.9s">{{ $displayVal2 }}</div>
                                <div class="bar-col-2" style="width: 32px; border-radius: 8px 8px 0 0; background: linear-gradient(to top, #E8EEF4, {{ $cc['light'] }}); height: 0; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1); position: relative; cursor: pointer"
                                     onmouseenter="this.style.filter='brightness(1.1)'" onmouseleave="this.style.filter='none'"></div>
                            </div>
                        @endif
                    </div>
                    <div style="margin-top: 10px; font-size: 13px; font-weight: 600; color: #6B7785">{{ $item['label'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
        <style>
            .{{ $scopeClass }} .bar-item-el.animated .bar-val { opacity: 1 !important; transform: translateY(0) !important; }
        </style>

    {{-- ============ LINE CHART ============ --}}
    @elseif($chartType === 'line' && $numValues >= 2)
        @php
            // SVG dimensions — use viewBox with xMidYMid meet to prevent distortion
            $svgW = 500;
            $svgH = $chartHeight;
            $padX = 60;
            $padTop = 30;
            $padBottom = 35;
            $plotW = $svgW - 2 * $padX;
            $plotH = $svgH - $padTop - $padBottom;
            $range = $maxValue - $minValue;
            if ($range == 0) $range = 1;

            // Primary series
            $points = [];
            foreach ($numericValues as $i => $val) {
                $x = $padX + ($numValues > 1 ? $i * $plotW / ($numValues - 1) : $plotW / 2);
                $y = $padTop + $plotH - (($val - $minValue) / $range) * $plotH;
                $points[] = ['x' => round($x, 1), 'y' => round($y, 1)];
            }
            $polylineStr = implode(' ', array_map(fn($p) => "{$p['x']},{$p['y']}", $points));
            $bottomY = $svgH - $padBottom;
            $areaD = "M{$points[0]['x']},{$points[0]['y']}";
            foreach (array_slice($points, 1) as $p) $areaD .= " L{$p['x']},{$p['y']}";
            $areaD .= " L{$points[count($points)-1]['x']},{$bottomY} L{$points[0]['x']},{$bottomY}Z";

            // Secondary series
            if ($hasSecondValue) {
                $points2 = [];
                foreach ($numericValues2 as $i => $val) {
                    if ($val <= 0) $val = $minValue;
                    $x = $padX + ($numValues > 1 ? $i * $plotW / ($numValues - 1) : $plotW / 2);
                    $y = $padTop + $plotH - (($val - $minValue) / $range) * $plotH;
                    $points2[] = ['x' => round($x, 1), 'y' => round($y, 1)];
                }
                $polylineStr2 = implode(' ', array_map(fn($p) => "{$p['x']},{$p['y']}", $points2));
                $areaD2 = "M{$points2[0]['x']},{$points2[0]['y']}";
                foreach (array_slice($points2, 1) as $p) $areaD2 .= " L{$p['x']},{$p['y']}";
                $areaD2 .= " L{$points2[count($points2)-1]['x']},{$bottomY} L{$points2[0]['x']},{$bottomY}Z";
            }
        @endphp

        <div
            class="{{ $scopeClass }}"
            x-data="{ shown: false }"
            x-init="
                const observer = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    shown = true;
                    observer.unobserve($el);
                    $el.querySelectorAll('.lc-line').forEach(p => p.classList.add('animated'));
                    $el.querySelectorAll('.lc-area').forEach(a => a.classList.add('animated'));
                    $el.querySelectorAll('.lc-dot').forEach((d, i) => setTimeout(() => d.classList.add('animated'), 400 + i * 300));
                    $el.querySelectorAll('.lc-label').forEach((l, i) => setTimeout(() => l.classList.add('animated'), 600 + i * 300));
                }, { threshold: 0.3 });
                observer.observe($el);
            "
            style="position: relative; border-bottom: 2px solid #D6E4F0; padding: 0"
        >
            <svg viewBox="0 0 {{ $svgW }} {{ $svgH + 25 }}" preserveAspectRatio="xMidYMid meet" style="width: 100%; display: block">
                {{-- Grid lines --}}
                @for($g = 0; $g < 3; $g++)
                    <line x1="{{ $padX }}" y1="{{ $padTop + $g * $plotH / 2 }}"
                          x2="{{ $svgW - $padX }}" y2="{{ $padTop + $g * $plotH / 2 }}"
                          stroke="#E8EEF4" stroke-width="1" stroke-dasharray="4 4"/>
                @endfor

                {{-- === SECONDARY === --}}
                @if($hasSecondValue)
                    <path class="lc-area" d="{{ $areaD2 }}" fill="url(#areaG2-{{ $blockId }})" style="opacity: 0; transition: opacity 1s ease 0.8s"/>
                    <polyline class="lc-line lc-line-sec" points="{{ $polylineStr2 }}"
                        fill="none" stroke="{{ $cc['light'] }}" stroke-width="2" stroke-linecap="round" stroke-dasharray="6 4"/>
                    @foreach($points2 as $i => $pt)
                        <circle class="lc-dot" cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" fill="#fff" stroke="{{ $cc['light'] }}" stroke-width="2.5" r="0"/>
                    @endforeach
                    @foreach($points2 as $i => $pt)
                        @php $lY = (abs(($points[$i]['y'] ?? 0) - $pt['y']) < 22) ? $pt['y'] + 18 : $pt['y'] - 12; @endphp
                        <text class="lc-label" x="{{ $pt['x'] }}" y="{{ $lY }}" text-anchor="middle"
                            style="font-family: Inter, PFDinTextCondPro, sans-serif; font-size: 13px; font-weight: 600; fill: {{ $cc['light'] }}; opacity: 0; transition: opacity 0.5s ease">{{ formatChartValue($values[$i]['value2'] ?? '0') }}</text>
                    @endforeach
                @endif

                {{-- === PRIMARY === --}}
                <path class="lc-area" d="{{ $areaD }}" fill="url(#areaG1-{{ $blockId }})" style="opacity: 0; transition: opacity 1s ease 0.8s"/>
                <polyline class="lc-line" points="{{ $polylineStr }}"
                    fill="none" stroke="{{ $cc['main'] }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                @foreach($points as $i => $pt)
                    <circle class="lc-dot" cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" fill="#fff" stroke="{{ $cc['main'] }}" stroke-width="3" r="0"/>
                @endforeach
                @foreach($points as $i => $pt)
                    <text class="lc-label" x="{{ $pt['x'] }}" y="{{ $pt['y'] - 14 }}" text-anchor="middle"
                        style="font-family: Inter, PFDinTextCondPro, sans-serif; font-size: 15px; font-weight: 700; fill: {{ $cc['text'] }}; opacity: 0; transition: opacity 0.5s ease">{{ formatChartValue($values[$i]['value'] ?? '0') }}</text>
                @endforeach

                {{-- Year labels --}}
                @foreach($points as $i => $pt)
                    <text x="{{ $pt['x'] }}" y="{{ $svgH + 15 }}" text-anchor="middle"
                        style="font-family: Inter, PFDinTextCondPro, sans-serif; font-size: 13px; font-weight: 600; fill: #6B7785">{{ $values[$i]['label'] ?? '' }}</text>
                @endforeach

                <defs>
                    <linearGradient id="areaG1-{{ $blockId }}" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="{{ $cc['main'] }}" stop-opacity="0.25"/>
                        <stop offset="100%" stop-color="{{ $cc['main'] }}" stop-opacity="0.02"/>
                    </linearGradient>
                    @if($hasSecondValue)
                    <linearGradient id="areaG2-{{ $blockId }}" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="{{ $cc['light'] }}" stop-opacity="0.2"/>
                        <stop offset="100%" stop-color="{{ $cc['light'] }}" stop-opacity="0.02"/>
                    </linearGradient>
                    @endif
                </defs>
            </svg>
        </div>

        <style>
            .{{ $scopeClass }} .lc-line {
                stroke-dasharray: 2000; stroke-dashoffset: 2000;
                transition: stroke-dashoffset 1.5s cubic-bezier(0.25, 1, 0.5, 1);
            }
            .{{ $scopeClass }} .lc-line-sec {
                stroke-dasharray: 2000; stroke-dashoffset: 2000;
                transition: stroke-dashoffset 1.5s cubic-bezier(0.25, 1, 0.5, 1);
            }
            .{{ $scopeClass }} .lc-line.animated { stroke-dashoffset: 0 !important; }
            .{{ $scopeClass }} .lc-line-sec.animated { stroke-dasharray: 6 4 !important; stroke-dashoffset: 0 !important; }
            .{{ $scopeClass }} .lc-area.animated { opacity: 1 !important; }
            .{{ $scopeClass }} .lc-dot { transition: r 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
            .{{ $scopeClass }} .lc-dot.animated { r: 7 !important; }
            .{{ $scopeClass }} .lc-label.animated { opacity: 1 !important; }
        </style>
    @endif
</div>
