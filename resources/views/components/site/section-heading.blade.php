@props([
    'eyebrow' => null,
    'number' => null,
    'dark' => false,
    'tag' => 'h2',
    'headingId' => null,
])

<div {{ $attributes }}>
    @if ($eyebrow)
        <p data-reveal @class(['eyebrow mb-3', 'text-lime' => $dark, 'text-violet' => ! $dark])>
            @if ($number){{ $number }} — @endif{{ $eyebrow }}
        </p>
    @endif
    <{{ $tag }} data-split @if ($headingId) id="{{ $headingId }}" @endif class="display text-[clamp(2.25rem,6vw,4rem)] leading-none">{{ $slot }}</{{ $tag }}>
</div>
