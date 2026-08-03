{{-- Rich Text Block with color and spacing --}}
@php
    $content = preg_replace(
        '/<p(?:\s[^>]*)?>\s*<\/p>/i',
        '<p><br></p>',
        $data['content'] ?? '',
    );
    $blockId = ($pageId ?? '') . '-' . ($blockId ?? '');
@endphp

@php
    $colorHex = match($data['text_color'] ?? 'default') {
        'primary' => '#00355A',
        'accent' => '#2196F3',
        'muted' => '#6B7785',
        'white' => '#FFFFFF',
        default => '#1A1A1A',
    };
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

<style>
    .rich-text-{{ $data['text_color'] ?? 'default' }} p,
    .rich-text-{{ $data['text_color'] ?? 'default' }} span,
    .rich-text-{{ $data['text_color'] ?? 'default' }} div {
        color: {{ $colorHex }} !important;
    }

    /* Override for inline text colors */
    .rich-text-{{ $data['text_color'] ?? 'default' }} span[data-color],
    .rich-text-{{ $data['text_color'] ?? 'default' }} span.color {
        color: var(--color) !important;
    }

    /* Restore paragraph spacing inside rich text blocks (overrides global * { margin: 0 }) */
    .page-block--rich-text p {
        margin-bottom: 0.75em;
    }
    .page-block--rich-text p:last-child {
        margin-bottom: 0;
    }
    /* Empty paragraphs (spacers from editor) get smaller spacing */
    .page-block--rich-text p:has(> br:only-child) {
        margin-bottom: 0.5em;
    }
    /* List spacing */
    .page-block--rich-text ul,
    .page-block--rich-text ol {
        margin-bottom: 0.75em;
    }
</style>

<div id="{{ $blockId }}" x-data="revealOnScroll()" class="page-block page-block--rich-text max-w-none {{ $spacingTop }} {{ $spacingBottom }} rich-text-{{ $data['text_color'] ?? 'default' }} [&_a]:text-[#2196F3] [&_a]:font-normal [&_a]:underline">
    {!! $data['content'] ?? '' !!}
</div>
