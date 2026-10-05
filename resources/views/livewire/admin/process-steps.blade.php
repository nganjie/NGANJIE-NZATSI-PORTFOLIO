@php($L = strtoupper($locale))

<x-admin.crud title="Méthode" subtitle="Les étapes affichées dans la section Méthode de l'accueil" add-label="Ajouter une étape" :show-form="$showForm" :editing="(bool) $editingId" :locale="$locale">
    <x-slot:list>
        @if ($items->isEmpty())
            <x-admin.empty-state title="Aucune étape" />
        @else
            <ol wire:sort="sortItem" class="rounded-2xl border border-line bg-white">
                @foreach ($items as $item)
                    <x-admin.crud-row :id="$item->id" :label="$item->title" :active="$editingId === $item->id">
                        <p class="font-semibold"><span class="mr-2 inline-grid size-7 place-items-center rounded-full bg-lime text-xs font-extrabold">{{ $loop->iteration }}</span>{{ $item->title }}</p>
                        <p class="truncate text-sm text-muted">{{ $item->body }}</p>
                    </x-admin.crud-row>
                @endforeach
            </ol>
        @endif
    </x-slot:list>

    <x-slot:form>
        <x-admin.field label="Titre ({{ $L }})" for="title-{{ $locale }}" error="title.{{ $locale }}">
            <input id="title-{{ $locale }}" type="text" wire:model="title.{{ $locale }}" class="admin-input">
        </x-admin.field>
        <x-admin.field label="Texte ({{ $L }})" for="body-{{ $locale }}" error="body.{{ $locale }}">
            <textarea id="body-{{ $locale }}" rows="4" wire:model="body.{{ $locale }}" class="admin-input"></textarea>
        </x-admin.field>
    </x-slot:form>
</x-admin.crud>
