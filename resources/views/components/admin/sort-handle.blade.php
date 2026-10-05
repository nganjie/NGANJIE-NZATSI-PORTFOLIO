@props(['up' => null, 'down' => null, 'label' => 'élément'])

<div class="flex items-center gap-0.5">
    <span wire:sort:handle class="grid h-11 w-7 cursor-grab place-items-center text-[#8e8d97]" title="Glisser pour réordonner" aria-hidden="true">
        <svg width="14" height="20" viewBox="0 0 14 20" fill="currentColor"><circle cx="4" cy="4" r="1.6"/><circle cx="10" cy="4" r="1.6"/><circle cx="4" cy="10" r="1.6"/><circle cx="10" cy="10" r="1.6"/><circle cx="4" cy="16" r="1.6"/><circle cx="10" cy="16" r="1.6"/></svg>
    </span>
    @if ($up)
        <button type="button" wire:click="{{ $up }}" class="sr-only focus:not-sr-only focus:rounded focus:bg-mist focus:px-2" aria-label="Monter {{ $label }}">↑</button>
    @endif
    @if ($down)
        <button type="button" wire:click="{{ $down }}" class="sr-only focus:not-sr-only focus:rounded focus:bg-mist focus:px-2" aria-label="Descendre {{ $label }}">↓</button>
    @endif
</div>
