<div
    class="transition-all duration-700 ease-out"
>
    <h2 id="{{Str::slug($block['data']['title'])}}"
        class="text-blue-600 font-medium text-[40px] scroll-mt-12 mb-6 md:text-[16px]">{{$block['data']['title']}}</h2>
    @php
        use Filament\Forms\Components\RichEditor\RichContentRenderer;
        use App\Filament\RichContent\TooltipRichContentPlugin;
    @endphp

    <div class="text-lg text-black-400 md:text-base leading-[160%]">
        {!!
            RichContentRenderer::make($block['data']['text'])
                ->plugins([
                    TooltipRichContentPlugin::make(),
                ])
                ->toHtml()
        !!}
    </div>
</div>
