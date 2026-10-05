@props([
    'media',
    'sizes' => '100vw',
    'eager' => false,
    'alt' => null,
    'conversions' => ['thumb' => 400, 'md' => 800, 'lg' => 1600],
])

@php
    /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
    $sources = collect($conversions)
        ->filter(fn ($width, $name) => $media->hasGeneratedConversion($name))
        ->map(fn ($width, $name) => $media->getUrl($name).' '.$width.'w');
    $src = $sources->isNotEmpty() ? $media->getUrl($sources->keys()->last()) : $media->getUrl();
    $width = $media->getCustomProperty('width');
    $height = $media->getCustomProperty('height');
    $altText = $alt ?? $media->getCustomProperty('alt.fr') ?? '';
@endphp

<img src="{{ $src }}"
    @if ($sources->isNotEmpty()) srcset="{{ $sources->join(', ') }}" sizes="{{ $sizes }}" @endif
    @if ($width && $height) width="{{ $width }}" height="{{ $height }}" @endif
    alt="{{ $altText }}"
    loading="{{ $eager ? 'eager' : 'lazy' }}"
    decoding="async"
    @if ($eager) fetchpriority="high" @endif
    {{ $attributes }}>
