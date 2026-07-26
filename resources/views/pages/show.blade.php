@extends('layouts.portal')

@section('content')
    @php
        $currentLang = session('locale', 'ru');
        $pageTitle = !empty($page->title_languages) && isset($page->title_languages[$currentLang])
            ? $page->title_languages[$currentLang]
            : $page->title;
    @endphp
    <article class="container mx-auto py-16 md:py-10">
        @if ($page->getFirstMediaUrl('cover'))
            <div class="mb-10">
                <img src="{{ $page->getFirstMediaUrl('cover') }}" alt="{{ $pageTitle }}" class="w-full rounded-2xl object-cover">
            </div>
        @endif

        <h1 class="mb-8 text-4xl font-semibold">{{ $pageTitle }}</h1>

        @foreach ($page->blocks as $block)
            <section class="mb-12">
                @if (! empty($block->data['title']))
                    <h2 class="mb-4 text-2xl font-semibold">{{ $block->data['title'] }}</h2>
                @endif

                @if (($block->type ?? null) === 'text' && ! empty($block->data['text']))
                    <div class="prose max-w-none">
                        {!! $block->data['text'] !!}
                    </div>
                @endif

                @if (($block->type ?? null) === 'image' && ! empty($block->data['image']))
                    <img
                        src="{{ Storage::disk('public')->url($block->data['image']) }}"
                        alt="{{ $block->data['title'] ?? '' }}"
                        class="rounded-2xl object-cover {{ ! empty($block->data['is_full_width']) ? 'w-full' : 'max-w-3xl' }}"
                    >
                @endif
            </section>
        @endforeach
    </article>
@endsection
