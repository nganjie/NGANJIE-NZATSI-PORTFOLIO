@props([
    'project',
    'media' => null,
    'sizes' => '(min-width: 1180px) 640px, 100vw',
    'eager' => false,
    'label' => true,
])

@php
    /** @var \App\Models\Project $project */
    $media ??= $project->getFirstMedia('cover');
    $accent = $project->accent_color;
    $longestWord = max(array_map('mb_strlen', explode(' ', (string) $project->title)) ?: [1]);
    $labelSize = round(min(11, 118 / max($longestWord, 1)), 2);
@endphp

<div {{ $attributes->class('media-zoom @container relative overflow-hidden rounded-md p-3.5') }} style="background-color: {{ $accent->hex() }}">
    @if ($media)
        <x-site.image :media="$media" :sizes="$sizes" :eager="$eager" :alt="$media->getCustomProperty('alt.'.app()->getLocale()) ?: $media->getCustomProperty('alt.fr') ?: __('Capture d\'écran de :title', ['title' => $project->title])"
            class="size-full rounded-[3px] object-cover object-top" />
    @else
        <div aria-hidden="true" @class([
            'flex size-full items-end rounded-[3px] border p-6',
            'border-white/45 text-white' => $accent->isDark(),
            'border-ink/30 text-ink' => ! $accent->isDark(),
        ])>
            @if ($label)
                <span class="media-label display leading-[0.92] [overflow-wrap:break-word] opacity-90" style="font-size: min({{ $labelSize }}cqw, 3.5rem)">{{ $project->title }}</span>
            @endif
        </div>
    @endif
</div>
