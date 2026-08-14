{{-- Chart Block (lollipop / bar / line) — with accent colors, 3 values, width, animation --}}
@php
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
    $chartType = $data['chart_type'] ?? 'lollipop';
    $animate = $data['animate'] ?? true;
    $title = $data['title'] ?? '';
    $unit = $data['unit'] ?? '';
    $values = $data['values'] ?? [];
    $numValues = count($values);

    // Parse numeric values (primary + optional secondary + tertiary)
    $numericValues = array_map(fn($v) => (float) str_replace(',', '.', $v['value'] ?? '0'), $values);
    $numericValues2 = array_map(fn($v) => (float) str_replace(',', '.', $v['value2'] ?? '0'), $values);
    $numericValues3 = array_map(fn($v) => (float) str_replace(',', '.', $v['value3'] ?? '0'), $values);
    $hasSecondValue = !empty(array_filter($numericValues2, fn($v) => $v > 0));
    $hasThirdValue = !empty(array_filter($numericValues3, fn($v) => $v > 0));

    $allValues = array_merge(
        $numericValues,
        $hasSecondValue ? array_filter($numericValues2, fn($v) => $v > 0) : [],
        $hasThirdValue ? array_filter($numericValues3, fn($v) => $v > 0) : []
    );
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
    // Accent color map for per-item override
    $accentColorMap = [
        'dark_blue' => ['main' => '#005B9C', 'dark' => '#00355A', 'light' => '#A5CBE5', 'text' => '#00355A', 'border' => '#005B9C'],
        'blue'      => ['main' => '#5BA4D9', 'dark' => '#005B9C', 'light' => '#B8D4EA', 'text' => '#005B9C', 'border' => '#5BA4D9'],
        'cyan'      => ['main' => '#00BCD4', 'dark' => '#00838F', 'light' => '#B2EBF2', 'text' => '#00838F', 'border' => '#00BCD4'],
        'teal'      => ['main' => '#4DB6AC', 'dark' => '#009688', 'light' => '#B2DFDB', 'text' => '#009688', 'border' => '#4DB6AC'],
        'orange'    => ['main' => '#FFB300', 'dark' => '#FF8F00', 'light' => '#FFE082', 'text' => '#E65100', 'border' => '#FFB300'],
        'green'     => ['main' => '#66BB6A', 'dark' => '#43A047', 'light' => '#A5D6A7', 'text' => '#2E7D32', 'border' => '#66BB6A'],
        'red'       => ['main' => '#EF5350', 'dark' => '#E53935', 'light' => '#EF9A9A', 'text' => '#C62828', 'border' => '#EF5350'],
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
    $chartHeight = match($data['chart_size'] ?? 'medium') {
        'compact' => 140, 'small' => 180, 'medium' => 220, 'large' => 280, 'xl' => 340, default => 220,
    };

    // Chart width
    $inGroup = $inGroup ?? false;
    $chartWidth = $inGroup ? '100%' : (($data['chart_width'] ?? '100') . '%');

    // Format value for display
    if (!function_exists('formatChartValue')) {
        function formatChartValue($val) {
            $float = (float) str_replace(',', '.', $val);
            // Always respect the original decimal places from the input
            $parts = preg_split('/[.,]/', $val);
            $decimals = isset($parts[1]) ? strlen($parts[1]) : 0;
            return number_format($float, $decimals, ',', ' ');
        }
    }

    $scopeClass = 'chart-' . md5($blockId);

    // Legend items — each maps to a data series (value, value2, value3)
    $legendItems = $data['legend'] ?? [];
    // Build per-series color map from legend
    $seriesColors = [];
    foreach ($legendItems as $li) {
        $s = $li['series'] ?? '';
        if ($s && !empty($li['color'])) {
            $seriesColors[$s] = $li['color'];
        }
    }
    // Default series colors from color scheme
    $seriesColorMap = [
        'value'  => $seriesColors['value']  ?? $cc['main'],
        'value2' => $seriesColors['value2'] ?? $cc['light'],
        'value3' => $seriesColors['value3'] ?? '#CDD6DE',
    ];
    $scopeId = 'sc-' . substr(md5($blockId), 0, 6);
    
    $lollipopLineOverlay = $data['lollipop_line_overlay'] ?? false;
    $polylinePoints = '';
    if ($chartType === 'lollipop' && $lollipopLineOverlay && $hasSecondValue) {
        $pts = [];
        $stemArea = $chartHeight - 40; // usable stem height (excluding label space)
        foreach ($values as $i => $item) {
            $v2 = $numericValues2[$i] ?? 0;
            $hp2 = ($maxValue > 0) ? round(($v2 / $maxValue) * 90, 1) : 0;
            $stemH = $stemArea * ($hp2 / 100);
            // Overlay dot center is at: stemH + 8px (margin-bottom) + 7px (half of 14px dot) from chart bottom
            // In SVG viewBox 0..1000, Y = 1000 - ((stemH + 15) / $chartHeight) * 1000
            $y = 1000 * (1 - (($stemH + 15) / $chartHeight));
            $x = (($i + 0.5) / $numValues) * 1000;
            $pts[] = round($x,1) . ',' . round($y,1);
        }
        $polylinePoints = implode(' ', $pts);
    }
@endphp

<div
    id="{{ $blockId }}"
    class="page-block page-block--chart flex flex-col h-full {{ $spacingTop }} {{ $spacingBottom }}"
    style="max-width: {{ $chartWidth }}{{ $inGroup ? '; position: relative; overflow: visible' : '' }}"
>
    {{-- Header --}}
    @if(trim(strip_tags($title)) !== '')
        <h3 class="text-2xl text-blue-500 font-normal leading-tight mb-2">{!! str_replace(['<p>', '</p>'], '', $title) !!}</h3>
    @endif
    @if(trim(strip_tags($unit)) !== '')
        <p class="text-lg leading-tight text-black-500 mb-6">{!! str_replace(['<p>', '</p>'], '', $unit) !!}</p>
    @endif

    {{-- ============ LOLLIPOP CHART ============ --}}
    @if($chartType === 'lollipop')
        <div
            class="{{ $scopeClass }} mt-auto"
            x-data="{ shown: {{ $animate ? 'false' : 'true' }} }"
            @if($animate)
            x-init="
                const observer = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    shown = true;
                    observer.unobserve($el);
                    const items = $el.querySelectorAll('.lolli-item');
                    const chartH = {{ $chartHeight }} - 40;
                    items.forEach((item, i) => {
                        setTimeout(() => {
                            requestAnimationFrame(() => {
                                requestAnimationFrame(() => {
                                    ['lolli-stem', 'lolli-stem-2', 'lolli-stem-3'].forEach(cls => {
                                        const stems = item.querySelectorAll('.' + cls);
                                        stems.forEach(stem => {
                                            const pctAttr = cls === 'lolli-stem' ? 'heightPct' : cls === 'lolli-stem-2' ? 'heightPct2' : 'heightPct3';
                                            const pct = parseFloat(item.dataset[pctAttr]) / 100;
                                            stem.style.height = (chartH * pct) + 'px';
                                        });
                                    });
                                    item.classList.add('animated');
                                });
                            });
                        }, i * 200);
                    });
                    const overlayLine = $el.querySelector('.lolli-overlay-line');
                    if(overlayLine) {
                        setTimeout(() => overlayLine.classList.add('animated'), 200);
                    }
                }, { threshold: 0.3 });
                observer.observe($el);
            "
            @endif
            style="display: flex; align-items: flex-end; justify-content: space-around; height: {{ $chartHeight }}px; position: relative; border-bottom: 2px solid #D6E4F0; padding: 0 20px"
        >
            @if($lollipopLineOverlay && $hasSecondValue && $polylinePoints)
                <svg viewBox="0 0 1000 1000" preserveAspectRatio="none" style="position: absolute; left: 20px; right: 20px; top: 0; bottom: 0; width: calc(100% - 40px); height: 100%; pointer-events: none; z-index: 1;">
                    <polyline points="{{ $polylinePoints }}" fill="none" stroke="{{ $seriesColorMap['value2'] }}" stroke-width="2" vector-effect="non-scaling-stroke"
                        class="lolli-overlay-line {{ $scopeId }}-s-value2"
                        style="stroke-dasharray: 2000; stroke-dashoffset: 2000; transition: stroke-dashoffset 1.5s cubic-bezier(0.25, 1, 0.5, 1) 0.5s;"
                    />
                </svg>
            @endif
            
            @foreach($values as $i => $item)
                @php
                    $val = $numericValues[$i];
                    $heightPct = $maxValue > 0 ? round(($val / $maxValue) * 90, 1) : 0;
                    $displayVal = formatChartValue($item['value'] ?? '0');
                    $val2 = $numericValues2[$i] ?? 0;
                    $heightPct2 = ($hasSecondValue && $maxValue > 0) ? round(($val2 / $maxValue) * 90, 1) : 0;
                    $val3 = $numericValues3[$i] ?? 0;
                    $heightPct3 = ($hasThirdValue && $maxValue > 0) ? round(($val3 / $maxValue) * 90, 1) : 0;
                    // Per-item accent color palette
                    $accent = (!empty($item['accent_color'])) ? ($accentColorMap[$item['accent_color']] ?? $cc) : $cc;
                    // === 3-tier color hierarchy: color_scheme < accent_color < legend ===
                    $eff1 = $accent['main'];
                    if (!empty($seriesColors['value'])) $eff1 = $seriesColors['value'];
                    $eff2 = $accent['light'];
                    if (!empty($seriesColors['value2'])) $eff2 = $seriesColors['value2'];
                    $eff3 = (!empty($item['accent_color'])) ? ($accent['light'] ?? '#CDD6DE') : '#CDD6DE';
                    if (!empty($seriesColors['value3'])) $eff3 = $seriesColors['value3'];
                @endphp
                <div
                    class="lolli-item"
                    data-height-pct="{{ $heightPct }}"
                    @if($hasSecondValue) data-height-pct2="{{ $heightPct2 }}" @endif
                    @if($hasThirdValue) data-height-pct3="{{ $heightPct3 }}" @endif
                    style="display: flex; flex-direction: column; align-items: center; position: relative; flex: 1; max-width: 140px"
                >
                    <div style="display: flex; align-items: flex-end; gap: {{ ($hasSecondValue || $hasThirdValue) ? '6px' : '0' }}">
                        {{-- Primary --}}
                        <div style="display: flex; flex-direction: column; align-items: center">
                            <div class="lolli-val {{ $scopeId }}-s-value" style="font-size: 18px; font-weight: 700; color: {{ $eff1 }}; margin-bottom: 8px; white-space: nowrap; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease, transform 0.5s ease">{{ $displayVal }}</div>
                            <div class="lolli-dot {{ $scopeId }}-s-value" style="width: 18px; height: 18px; border-radius: 50%; background: #fff; border: 3px solid {{ $eff1 }}; position: relative; z-index: 2; transform: scale(0); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); flex-shrink: 0"></div>
                            <div class="lolli-stem {{ $scopeId }}-s-value" style="width: 3px; background: linear-gradient(to top, {{ $eff1 }}40, {{ $eff1 }}); border-radius: 3px 3px 0 0; height: 0; transition: height 1s cubic-bezier(0.25, 1, 0.5, 1)"></div>
                        </div>
                        {{-- Secondary --}}
                        @if($hasSecondValue && $val2 > 0)
                            @if($lollipopLineOverlay)
                                <div style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; pointer-events: none; z-index: 5;">
                                    <div class="lolli-stem-2" style="height: 0; width: 0; transition: height 1s cubic-bezier(0.25, 1, 0.5, 1); position: relative;">
                                        <div style="position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; margin-bottom: 8px;">
                                            <div class="lolli-val {{ $scopeId }}-s-value2" style="font-size: 18px; font-weight: 700; color: {{ $eff2 }}; margin-bottom: 8px; white-space: nowrap; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.1s, transform 0.5s ease 0.1s">{{ formatChartValue($item['value2'] ?? '0') }}</div>
                                            <div class="lolli-dot {{ $scopeId }}-s-value2" style="width: 14px; height: 14px; border-radius: 50%; background: #fff; border: 3px solid {{ $eff2 }}; transform: scale(0); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s;"></div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div style="display: flex; flex-direction: column; align-items: center">
                                    <div class="lolli-val {{ $scopeId }}-s-value2" style="font-size: 18px; font-weight: 700; color: {{ $eff2 }}; margin-bottom: 8px; white-space: nowrap; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.1s, transform 0.5s ease 0.1s">{{ formatChartValue($item['value2'] ?? '0') }}</div>
                                    <div class="lolli-dot {{ $scopeId }}-s-value2" style="width: 14px; height: 14px; border-radius: 50%; background: #fff; border: 3px solid {{ $eff2 }}; position: relative; z-index: 2; transform: scale(0); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s; flex-shrink: 0"></div>
                                    <div class="lolli-stem-2 {{ $scopeId }}-s-value2" style="width: 3px; background: linear-gradient(to top, #E8EEF4, {{ $eff2 }}); border-radius: 3px 3px 0 0; height: 0; transition: height 1s cubic-bezier(0.25, 1, 0.5, 1)"></div>
                                </div>
                            @endif
                        @endif
                        {{-- Tertiary --}}
                        @if($hasThirdValue && $val3 > 0)
                            <div style="display: flex; flex-direction: column; align-items: center">
                                <div class="lolli-val {{ $scopeId }}-s-value3" style="font-size: 18px; font-weight: 700; color: {{ $eff3 }}; margin-bottom: 8px; white-space: nowrap; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.2s, transform 0.5s ease 0.2s">{{ formatChartValue($item['value3'] ?? '0') }}</div>
                                <div class="lolli-dot {{ $scopeId }}-s-value3" style="width: 14px; height: 14px; border-radius: 50%; background: #fff; border: 3px solid {{ $eff3 }}; position: relative; z-index: 2; transform: scale(0); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s; flex-shrink: 0"></div>
                                <div class="lolli-stem-3 {{ $scopeId }}-s-value3" style="width: 3px; background: linear-gradient(to top, #F1F5FC, {{ $eff3 }}); border-radius: 3px 3px 0 0; height: 0; transition: height 1s cubic-bezier(0.25, 1, 0.5, 1)"></div>
                            </div>
                        @endif
                    </div>
                    <div style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); margin-top: 12px; width: 140%; text-align: center; font-size: 13px; font-weight: 600; color: #6B7785; line-height: 1.3">{{ $item['label'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
        <div style="height: 60px"></div>
        <style>
            .{{ $scopeClass }} .lolli-item.animated .lolli-val { opacity: 1 !important; transform: translateY(0) !important; }
            .{{ $scopeClass }} .lolli-item.animated .lolli-dot { transform: scale(1) !important; }
            .{{ $scopeClass }} .lolli-overlay-line.animated { stroke-dashoffset: 0 !important; }
        </style>

    {{-- ============ BAR CHART ============ --}}
    @elseif($chartType === 'bar')
        <div
            class="{{ $scopeClass }} mt-auto"
            x-data="{ shown: {{ $animate ? 'false' : 'true' }} }"
            @if($animate)
            x-init="
                const observer = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    shown = true;
                    observer.unobserve($el);
                    const items = $el.querySelectorAll('.bar-item-el');
                    const chartH = {{ $chartHeight }} - 10;
                    items.forEach((item, i) => {
                        setTimeout(() => {
                            requestAnimationFrame(() => {
                                requestAnimationFrame(() => {
                                    ['bar-col', 'bar-col-2', 'bar-col-3'].forEach(cls => {
                                        const col = item.querySelector('.' + cls);
                                        if (col) {
                                            const pctAttr = cls === 'bar-col' ? 'heightPct' : cls === 'bar-col-2' ? 'heightPct2' : 'heightPct3';
                                            const pct = parseFloat(item.dataset[pctAttr]) / 100;
                                            col.style.height = (chartH * pct) + 'px';
                                        }
                                    });
                                    item.classList.add('animated');
                                });
                            });
                        }, i * 200);
                    });
                }, { threshold: 0.3 });
                observer.observe($el);
            "
            @endif
            style="display: flex; align-items: flex-end; justify-content: space-around; height: {{ $chartHeight }}px; position: relative; border-bottom: 2px solid #D6E4F0; padding: 0 10px"
        >
            @foreach($values as $i => $item)
                @php
                    $val = $numericValues[$i];
                    $heightPct = $maxValue > 0 ? round(($val / $maxValue) * 90, 1) : 0;
                    $displayVal = formatChartValue($item['value'] ?? '0');
                    $val2 = $numericValues2[$i] ?? 0;
                    $heightPct2 = ($hasSecondValue && $maxValue > 0) ? round(($val2 / $maxValue) * 90, 1) : 0;
                    $val3 = $numericValues3[$i] ?? 0;
                    $heightPct3 = ($hasThirdValue && $maxValue > 0) ? round(($val3 / $maxValue) * 90, 1) : 0;
                    $accent = (!empty($item['accent_color'])) ? ($accentColorMap[$item['accent_color']] ?? $cc) : $cc;
                    $barW = ($hasSecondValue || $hasThirdValue) ? '28px' : '48px';
                    // === 3-tier color hierarchy: color_scheme < accent_color < legend ===
                    $eff1 = $accent['main'];
                    if (!empty($seriesColors['value'])) $eff1 = $seriesColors['value'];
                    $eff2 = $accent['light'];
                    if (!empty($seriesColors['value2'])) $eff2 = $seriesColors['value2'];
                    $eff3 = (!empty($item['accent_color'])) ? ($accent['light'] ?? '#CDD6DE') : '#CDD6DE';
                    if (!empty($seriesColors['value3'])) $eff3 = $seriesColors['value3'];
                @endphp
                <div
                    class="bar-item-el"
                    data-height-pct="{{ $heightPct }}"
                    @if($hasSecondValue) data-height-pct2="{{ $heightPct2 }}" @endif
                    @if($hasThirdValue) data-height-pct3="{{ $heightPct3 }}" @endif
                    style="display: flex; flex-direction: column; align-items: center; position: relative; flex: 1; max-width: 120px"
                >
                    <div style="display: flex; align-items: flex-end; gap: {{ ($hasSecondValue || $hasThirdValue) ? '3px' : '0' }}">
                        {{-- Primary bar --}}
                        <div style="display: flex; flex-direction: column; align-items: center">
                            <div class="bar-val {{ $scopeId }}-s-value" style="font-size: 16px; font-weight: 700; color: {{ $eff1 }}; margin-bottom: 8px; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.8s, transform 0.5s ease 0.8s; white-space: nowrap">{{ $displayVal }}</div>
                            <div class="bar-col {{ $scopeId }}-s-value" style="width: {{ $barW }}; border-radius: 8px 8px 0 0; background: linear-gradient(to top, {{ $eff1 }}40, {{ $eff1 }}); height: 0; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1); position: relative; cursor: pointer"
                                 onmouseenter="this.style.filter='brightness(1.1)'" onmouseleave="this.style.filter='none'"></div>
                        </div>
                        {{-- Secondary bar --}}
                        @if($hasSecondValue && $val2 > 0)
                            <div style="display: flex; flex-direction: column; align-items: center">
                                <div class="bar-val {{ $scopeId }}-s-value2" style="font-size: 13px; font-weight: 700; color: {{ $eff2 }}; margin-bottom: 8px; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 0.9s, transform 0.5s ease 0.9s; white-space: nowrap">{{ formatChartValue($item['value2'] ?? '0') }}</div>
                                <div class="bar-col-2 {{ $scopeId }}-s-value2" style="width: {{ $barW }}; border-radius: 8px 8px 0 0; background: linear-gradient(to top, #E8EEF4, {{ $eff2 }}); height: 0; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1); cursor: pointer"
                                     onmouseenter="this.style.filter='brightness(1.1)'" onmouseleave="this.style.filter='none'"></div>
                            </div>
                        @endif
                        {{-- Tertiary bar --}}
                        @if($hasThirdValue && $val3 > 0)
                            <div style="display: flex; flex-direction: column; align-items: center">
                                <div class="bar-val {{ $scopeId }}-s-value3" style="font-size: 12px; font-weight: 600; color: {{ $eff3 }}; margin-bottom: 8px; opacity: 0; transform: translateY(10px); transition: opacity 0.5s ease 1s, transform 0.5s ease 1s; white-space: nowrap">{{ formatChartValue($item['value3'] ?? '0') }}</div>
                                <div class="bar-col-3 {{ $scopeId }}-s-value3" style="width: 24px; border-radius: 6px 6px 0 0; background: linear-gradient(to top, #F1F5FC, {{ $eff3 }}); height: 0; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1); cursor: pointer"
                                     onmouseenter="this.style.filter='brightness(1.1)'" onmouseleave="this.style.filter='none'"></div>
                            </div>
                        @endif
                    </div>
                    <div style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); margin-top: 12px; width: 140%; text-align: center; font-size: 13px; font-weight: 600; color: #6B7785; line-height: 1.3">{{ $item['label'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
        <div style="height: 60px"></div>
        <style>
            .{{ $scopeClass }} .bar-item-el.animated .bar-val { opacity: 1 !important; transform: translateY(0) !important; }
        </style>

    {{-- ============ HORIZONTAL BAR CHART ============ --}}
    @elseif($chartType === 'bar_horizontal')
        <div
            class="{{ $scopeClass }} mt-auto"
            x-data="{ shown: {{ $animate ? 'false' : 'true' }} }"
            @if($animate)
            x-init="
                const observer = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    shown = true;
                    observer.unobserve($el);
                    const items = $el.querySelectorAll('.hbar-row');
                    items.forEach((item, i) => {
                        setTimeout(() => {
                            requestAnimationFrame(() => {
                                requestAnimationFrame(() => {
                                    const bar = item.querySelector('.hbar-fill');
                                    if (bar) bar.style.width = bar.dataset.widthPct + '%';
                                    item.classList.add('animated');
                                });
                            });
                        }, i * 150);
                    });
                }, { threshold: 0.2 });
                observer.observe($el);
            "
            @endif
            style="display: flex; flex-direction: column; gap: 14px"
        >
            @foreach($values as $i => $item)
                @php
                    $val = $numericValues[$i];
                    $widthPct = $maxValue > 0 ? round(($val / $maxValue) * 85, 1) : 0;
                    $displayVal = formatChartValue($item['value'] ?? '0');
                    $accent = (!empty($item['accent_color'])) ? ($accentColorMap[$item['accent_color']] ?? $cc) : $cc;
                @endphp
                <div class="hbar-row" style="display: flex; align-items: center; gap: 20px">
                    <div class="hbar-label" style="min-width: 200px; font-size: 15px; font-weight: 500; color: #3D5066; text-align: left; line-height: 1.4; opacity: 0; transform: translateX(-10px); transition: opacity 0.5s ease, transform 0.5s ease">{{ $item['label'] ?? '' }}</div>
                    <div style="flex: 1; position: relative; height: 38px; display: flex; align-items: center">
                        <div class="hbar-fill" data-width-pct="{{ $widthPct }}"
                             style="height: 100%; width: 0; border-radius: 0 10px 10px 0; background: linear-gradient(90deg, {{ $accent['light'] }}, {{ $accent['main'] }}); transition: width 1.2s cubic-bezier(0.25, 1, 0.5, 1); position: relative; cursor: pointer"
                             onmouseenter="this.style.filter='brightness(1.08)'; this.style.boxShadow='0 4px 16px rgba(33,150,243,0.25)'" onmouseleave="this.style.filter='none'; this.style.boxShadow='none'">
                        </div>
                        <div class="hbar-val" style="margin-left: 14px; font-size: 20px; font-weight: 700; color: {{ $accent['text'] }}; white-space: nowrap; opacity: 0; transform: translateX(-10px); transition: opacity 0.5s ease 0.8s, transform 0.5s ease 0.8s">{{ $displayVal }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <style>
            .{{ $scopeClass }} .hbar-row.animated .hbar-val { opacity: 1 !important; transform: translateX(0) !important; }
            .{{ $scopeClass }} .hbar-row.animated .hbar-label { opacity: 1 !important; transform: translateX(0) !important; }
        </style>

    {{-- ============ LINE CHART ============ --}}
    @elseif($chartType === 'line' && $numValues >= 2)
        @php
            $svgW = 500;
            $svgH = $chartHeight;
            $padX = 60;
            $padTop = 30;
            $padBottom = 35;
            $plotW = $svgW - 2 * $padX;
            $plotH = $svgH - $padTop - $padBottom;
            $range = $maxValue - $minValue;
            if ($range == 0) $range = 1;

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
            class="{{ $scopeClass }} mt-auto"
            x-data="{ shown: {{ $animate ? 'false' : 'true' }} }"
            @if($animate)
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
            @endif
            style="position: relative; border-bottom: 2px solid #D6E4F0; padding: 0"
        >
            <svg viewBox="0 0 {{ $svgW }} {{ $svgH }}" preserveAspectRatio="xMidYMid meet" style="width: 100%; display: block; overflow: visible">
                @for($g = 0; $g < 3; $g++)
                    <line x1="{{ $padX }}" y1="{{ $padTop + $g * $plotH / 2 }}"
                          x2="{{ $svgW - $padX }}" y2="{{ $padTop + $g * $plotH / 2 }}"
                          stroke="#E8EEF4" stroke-width="1" stroke-dasharray="4 4"/>
                @endfor

                @if($hasSecondValue)
                    <path class="lc-area" d="{{ $areaD2 }}" fill="url(#areaG2-{{ $blockId }})" style="opacity: 0; transition: opacity 1s ease 0.8s"/>
                    <polyline class="lc-line lc-line-sec" points="{{ $polylineStr2 }}" fill="none" stroke="{{ $cc['light'] }}" stroke-width="2" stroke-linecap="round" stroke-dasharray="6 4"/>
                    @foreach($points2 as $i => $pt)
                        <circle class="lc-dot" cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" fill="#fff" stroke="{{ $cc['light'] }}" stroke-width="2.5" r="0"/>
                    @endforeach
                    @foreach($points2 as $i => $pt)
                        @php $lY = (abs(($points[$i]['y'] ?? 0) - $pt['y']) < 22) ? $pt['y'] + 18 : $pt['y'] - 12; @endphp
                        <text class="lc-label" x="{{ $pt['x'] }}" y="{{ $lY }}" text-anchor="middle"
                            style="font-family: Inter, PFDinTextCondPro, sans-serif; font-size: 13px; font-weight: 600; fill: {{ $cc['light'] }}; opacity: 0; transition: opacity 0.5s ease">{{ formatChartValue($values[$i]['value2'] ?? '0') }}</text>
                    @endforeach
                @endif

                <path class="lc-area" d="{{ $areaD }}" fill="url(#areaG1-{{ $blockId }})" style="opacity: 0; transition: opacity 1s ease 0.8s"/>
                <polyline class="lc-line" points="{{ $polylineStr }}" fill="none" stroke="{{ $cc['main'] }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                @foreach($points as $i => $pt)
                    <circle class="lc-dot" cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" fill="#fff" stroke="{{ $cc['main'] }}" stroke-width="3" r="0"/>
                @endforeach
                @foreach($points as $i => $pt)
                    <text class="lc-label" x="{{ $pt['x'] }}" y="{{ $pt['y'] - 14 }}" text-anchor="middle"
                        style="font-family: Inter, PFDinTextCondPro, sans-serif; font-size: 15px; font-weight: 700; fill: {{ $cc['text'] }}; opacity: 0; transition: opacity 0.5s ease">{{ formatChartValue($values[$i]['value'] ?? '0') }}</text>
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
            @foreach($points as $i => $pt)
                <div style="position: absolute; top: 100%; left: {{ ($pt['x'] / $svgW) * 100 }}%; transform: translateX(-50%); margin-top: 12px; width: 140px; text-align: center; font-size: 13px; font-weight: 600; color: #6B7785; line-height: 1.3">{{ $values[$i]['label'] ?? '' }}</div>
            @endforeach
        </div>
        <div style="height: 60px"></div>

        <style>
            .{{ $scopeClass }} .lc-line { stroke-dasharray: 2000; stroke-dashoffset: 2000; transition: stroke-dashoffset 1.5s cubic-bezier(0.25, 1, 0.5, 1); }
            .{{ $scopeClass }} .lc-line-sec { stroke-dasharray: 2000; stroke-dashoffset: 2000; transition: stroke-dashoffset 1.5s cubic-bezier(0.25, 1, 0.5, 1); }
            .{{ $scopeClass }} .lc-line.animated { stroke-dashoffset: 0 !important; }
            .{{ $scopeClass }} .lc-line-sec.animated { stroke-dasharray: 6 4 !important; stroke-dashoffset: 0 !important; }
            .{{ $scopeClass }} .lc-area.animated { opacity: 1 !important; }
            .{{ $scopeClass }} .lc-dot { transition: r 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
            .{{ $scopeClass }} .lc-dot.animated { r: 7 !important; }
            .{{ $scopeClass }} .lc-label.animated { opacity: 1 !important; }
        </style>
    @endif

    {{-- ============ OPTIONAL LEGEND ============ --}}
    @if($inGroup)
        {{-- In a group: legend is positioned outside flex flow so chart areas align --}}
        @if(!empty($legendItems))
            <div style="position: absolute; top: 100%; left: 0; right: 0; z-index: 5;">
                <div class="flex flex-wrap items-center gap-x-8 gap-y-3 pt-4" style="border-top: 1px solid #E8EEF4">
                    @foreach($legendItems as $lIdx => $legendItem)
                        @php $lSeries = $legendItem['series'] ?? 'value'; @endphp
                        <div class="{{ $scopeId }}-legend flex items-center gap-2.5 cursor-pointer transition-opacity duration-300 py-1 px-2 rounded-lg hover:bg-gray-50"
                             data-series="{{ $lSeries }}"
                        >
                            <div style="width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; background-color: {{ !empty($legendItem['color']) ? $legendItem['color'] : $seriesColorMap[$lSeries] }}"></div>
                            <span class="text-sm text-[#4A5568] leading-snug">{{ $legendItem['label'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @elseif(!empty($legendItems))
        <div class="flex flex-wrap items-center gap-x-8 gap-y-3 mt-6 pt-4" style="border-top: 1px solid #E8EEF4">
            @foreach($legendItems as $lIdx => $legendItem)
                @php $lSeries = $legendItem['series'] ?? 'value'; @endphp
                <div class="{{ $scopeId }}-legend flex items-center gap-2.5 cursor-pointer transition-opacity duration-300 py-1 px-2 rounded-lg hover:bg-gray-50"
                     data-series="{{ $lSeries }}"
                >
                    <div style="width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; background-color: {{ !empty($legendItem['color']) ? $legendItem['color'] : $seriesColorMap[$lSeries] }}"></div>
                    <span class="text-sm text-[#4A5568] leading-snug">{{ $legendItem['label'] ?? '' }}</span>
                </div>
            @endforeach
        </div>
    @endif
    @if(!empty($legendItems))

        <script>
        (function() {
            function initLegend() {
                var block = document.getElementById('{!! $blockId !!}');
                if (!block) return;
                var legends = block.querySelectorAll('.{{ $scopeId }}-legend');
                if (!legends.length) return;

                function highlight(series) {
                    ['value', 'value2', 'value3'].forEach(function(s) {
                        var els = block.querySelectorAll('.{{ $scopeId }}-s-' + s);
                        els.forEach(function(el) {
                            if (s === series) {
                                el.style.opacity = '1';
                                el.style.filter = 'brightness(1.08)';
                                el.style.transform = el.dataset.origTransform || '';
                            } else {
                                el.style.opacity = '0.25';
                                el.style.filter = 'none';
                            }
                        });
                    });
                    legends.forEach(function(l) {
                        l.style.opacity = l.dataset.series === series ? '1' : '0.4';
                    });
                }

                function reset() {
                    ['value', 'value2', 'value3'].forEach(function(s) {
                        var els = block.querySelectorAll('.{{ $scopeId }}-s-' + s);
                        els.forEach(function(el) {
                            el.style.opacity = '1';
                            el.style.filter = 'none';
                            el.style.transform = el.dataset.origTransform || '';
                        });
                    });
                    legends.forEach(function(l) { l.style.opacity = '1'; });
                }

                legends.forEach(function(leg) {
                    leg.addEventListener('mouseenter', function() { highlight(leg.dataset.series); });
                    leg.addEventListener('mouseleave', reset);
                });
            }

            if (document.readyState === 'complete') { setTimeout(initLegend, 200); }
            else { window.addEventListener('load', function() { setTimeout(initLegend, 200); }); }
            document.addEventListener('livewire:navigated', function() { setTimeout(initLegend, 300); });
        })();
        </script>
    @endif
</div>
