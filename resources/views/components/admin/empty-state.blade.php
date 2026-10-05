@props(['title'])

<div class="rounded-2xl border-2 border-dashed border-line p-10 text-center">
    <p class="font-display text-lg font-bold">{{ $title }}</p>
    @if ($slot->isNotEmpty())
        <div class="mt-3 text-muted">{{ $slot }}</div>
    @endif
</div>
