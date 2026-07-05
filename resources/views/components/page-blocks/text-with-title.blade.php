<div
    class="transition-all duration-700 ease-out"
>
    <h2 id="{{Str::slug($block['data']['title'])}}"
        class="text-blue-600 font-medium text-[40px] scroll-mt-12 mb-6 md:text-[16px]">{{$block['data']['title']}}</h2>
    <p class="text-lg text-black-400 md:text-base leading-[160%]">
        {!! $block['data']['text'] !!}
    </p>
</div>
