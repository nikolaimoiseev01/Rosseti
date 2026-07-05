{{-- Two Columns Text Block --}}
<div class="grid grid-cols-2 gap-8 md:grid-cols-1">
    <div class="prose prose-lg max-w-none text-[#333] prose-p:leading-relaxed prose-a:text-[#005B9C]">
        {!! $data['left'] !!}
    </div>
    <div class="prose prose-lg max-w-none text-[#333] prose-p:leading-relaxed prose-a:text-[#005B9C]">
        {!! $data['right'] !!}
    </div>
</div>
