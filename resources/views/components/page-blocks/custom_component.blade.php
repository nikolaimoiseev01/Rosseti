@php
    $componentName = $data['component_name'] ?? null;
    $componentData = $data['component_data'] ?? null;
    $htmlWidth = $data['html_width'] ?? '100';
    $preventMerge = $data['prevent_merge'] ?? false;
    $spacingTop = $data['spacing_top'] ?? 'none';
    $spacingBottom = $data['spacing_bottom'] ?? 'xl';

    // Парсим JSON данные
    $parsedData = [];
    if ($componentData) {
        $parsedData = json_decode($componentData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $parsedData = [];
        }
    }

    // Определяем классы отступов
    $spacingClasses = [
        'none' => '',
        'small' => 'pt-2 pb-2',
        'normal' => 'pt-4 pb-4',
        'large' => 'pt-8 pb-8',
        'xl' => 'pt-12 pb-12',
        '2xl' => 'pt-16 pb-16',
        '3xl' => 'pt-24 pb-24',
    ];

    $topClass = $spacingClasses[$spacingTop] ?? '';
    $bottomClass = $spacingClasses[$spacingBottom] ?? '';
@endphp

@if ($componentName)
    <div class="custom-component-wrapper {{ $topClass }} {{ $bottomClass }}"
         style="{{ $preventMerge ? 'width: 100%; clear: both;' : '' }} width: {{ $htmlWidth }}%;">
        @include('components.custom-page-blocks.' . $componentName, $parsedData)
    </div>
@else
    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <p class="text-yellow-600">Компонент не выбран. Пожалуйста, выберите компонент в настройках блока.</p>
    </div>
@endif
