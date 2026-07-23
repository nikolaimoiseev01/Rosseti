@php
    use Filament\Forms\Components\RichEditor\RichContentRenderer;
    use App\Filament\RichContent\TooltipRichContentPlugin;

    $titleColor = $data['color'] ?? 'text-blue-600';
    $textColor = $data['color'] ?? 'text-black-500';

    $spacingTop = match($data['spacing_top'] ?? 'none') {
        'none' => '',
        'small' => 'mt-2',
        'normal' => 'mt-4', 'medium' => 'mt-6',
        'large' => 'mt-8',
        'xl' => 'mt-12',
        '2xl' => 'mt-16',
        '3xl' => 'mt-24',
        default => '',
    };
    $spacingBottom = match($data['spacing_bottom'] ?? 'xl') {
        'none' => '',
        'small' => 'mb-2',
        'normal' => 'mb-4', 'medium' => 'mb-6',
        'large' => 'mb-8',
        'xl' => 'mb-12',
        '2xl' => 'mb-16',
        '3xl' => 'mb-24',
        default => 'mb-12',
    };
@endphp

<div x-data="revealOnScroll()" class="page-block page-block--text-with-title transition-all duration-700 ease-out {{ $spacingTop }} {{ $spacingBottom }}">
    <h2 id="{{Str::slug($data['title'] ?? '')}}"
        class="{{ $titleColor }} font-medium text-[40px] scroll-mt-12 mb-6 md:text-[16px]">{{$data['title'] ?? ''}}</h2>

    @if(!empty($data['text']))
    <div class="text-lg {{ $textColor }} md:text-base leading-[160%]">
        {!!$data['text']!!}
    </div>
    @endif
</div>
