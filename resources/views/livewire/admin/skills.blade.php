@php($L = strtoupper($locale))

<x-admin.crud title="Compétences" subtitle="Les domaines affichés dans la section Compétences de l'accueil" add-label="Ajouter un domaine" :show-form="$showForm" :editing="(bool) $editingId" :locale="$locale">
    <x-slot:list>
        @if ($items->isEmpty())
            <x-admin.empty-state title="Aucun domaine de compétence" />
        @else
            <ul wire:sort="sortItem" class="rounded-2xl border border-line bg-white">
                @foreach ($items as $item)
                    <x-admin.crud-row :id="$item->id" :label="$item->title" :active="$editingId === $item->id">
                        <p class="font-semibold">{{ $item->title }}</p>
                        <p class="truncate text-sm text-muted">{{ implode(' · ', $item->tagList()) }}</p>
                    </x-admin.crud-row>
                @endforeach
            </ul>
        @endif
    </x-slot:list>

    <x-slot:form>
        <x-admin.field label="Titre ({{ $L }})" for="title-{{ $locale }}" error="title.{{ $locale }}">
            <input id="title-{{ $locale }}" type="text" wire:model="title.{{ $locale }}" class="admin-input">
        </x-admin.field>
        <x-admin.field label="Description ({{ $L }})" for="description-{{ $locale }}" error="description.{{ $locale }}">
            <textarea id="description-{{ $locale }}" rows="3" wire:model="description.{{ $locale }}" class="admin-input"></textarea>
        </x-admin.field>
        <x-admin.field label="Étiquettes ({{ $L }})" for="tags-{{ $locale }}" error="tags.{{ $locale }}" help="Une étiquette par ligne">
            <textarea id="tags-{{ $locale }}" rows="6" wire:model="tags.{{ $locale }}" class="admin-input"></textarea>
        </x-admin.field>
    </x-slot:form>
</x-admin.crud>
