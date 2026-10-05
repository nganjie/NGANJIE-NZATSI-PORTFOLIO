@props(['id', 'label', 'active' => false])

<li wire:key="item-{{ $id }}" wire:sort:item="{{ $id }}" @class(['flex items-center gap-3 border-b border-mist px-3 py-3 last:border-b-0', 'bg-[#f4f0ff]' => $active])>
    <x-admin.sort-handle up="moveUp({{ $id }})" down="moveDown({{ $id }})" :label="$label" />
    <div class="min-w-0 flex-1">{{ $slot }}</div>
    <div class="flex shrink-0 items-center gap-3">
        {{ $actions ?? '' }}
        <button type="button" wire:click="edit({{ $id }})" class="admin-link text-sm">Modifier</button>
        <button type="button" wire:click="delete({{ $id }})" wire:confirm="Supprimer « {{ $label }} » ?" class="cursor-pointer text-sm text-danger hover:underline">Supprimer</button>
    </div>
</li>
