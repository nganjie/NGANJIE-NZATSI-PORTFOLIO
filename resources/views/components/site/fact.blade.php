@props(['label'])

<div data-reveal class="rounded-2xl border border-line p-6">
    <dt class="eyebrow mb-2 text-muted">{{ $label }}</dt>
    <dd class="font-semibold">{{ $slot }}</dd>
</div>
