@props(['title', 'subtitle' => null, 'breadcrumb' => null])

<div class="mb-8 flex flex-wrap items-end justify-between gap-4">
    <div>
        @if ($breadcrumb)
            <p class="mb-2 text-sm text-muted">{{ $breadcrumb }}</p>
        @elseif ($subtitle)
            <p class="mb-1 text-muted">{{ $subtitle }}</p>
        @endif
        <h1 class="display text-[clamp(2rem,4vw,2.75rem)] leading-none">{{ $title }}</h1>
    </div>
    @if (isset($actions))
        <div class="flex flex-wrap gap-2.5">{{ $actions }}</div>
    @endif
</div>
