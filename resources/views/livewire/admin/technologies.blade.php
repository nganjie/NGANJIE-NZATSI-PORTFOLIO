@php($L = strtoupper($locale))

<x-admin.crud title="Technologies" :subtitle="$homeCount.' / '.\App\Models\Technology::HOME_LIMIT.' affichées sur l\'accueil'" add-label="Ajouter une technologie" :show-form="$showForm" :editing="(bool) $editingId" :locale="$locale">
    <x-slot:list>
        @if ($homeCount > \App\Models\Technology::HOME_LIMIT)
            <p role="alert" class="mb-4 rounded-xl bg-[#fff4e5] p-4 text-sm text-[#7a4500]">
                {{ $homeCount }} technologies sont cochées pour l'accueil : seules les {{ \App\Models\Technology::HOME_LIMIT }} premières de la liste seront affichées.
            </p>
        @endif
        @if ($items->isEmpty())
            <x-admin.empty-state title="Aucune technologie" />
        @else
            <ul wire:sort="sortItem" class="rounded-2xl border border-line bg-white">
                @foreach ($items as $item)
                    <x-admin.crud-row :id="$item->id" :label="$item->name" :active="$editingId === $item->id">
                        <p class="font-semibold">{{ $item->name }}</p>
                        <p class="text-sm text-muted">{{ $item->category }} · {{ $item->projects_count }} {{ \Illuminate\Support\Str::plural('projet', $item->projects_count) }}</p>
                        <x-slot:actions>
                            <x-admin.toggle :label="'Afficher '.$item->name.' sur l\'accueil'" sr-only-label :checked="$item->show_on_home" wire:click="toggleHome({{ $item->id }})" />
                        </x-slot:actions>
                    </x-admin.crud-row>
                @endforeach
            </ul>
        @endif
    </x-slot:list>

    <x-slot:form>
        <x-admin.field label="Nom" for="name">
            <input id="name" type="text" wire:model="name" class="admin-input">
        </x-admin.field>
        <x-admin.field label="Catégorie ({{ $L }})" for="category-{{ $locale }}" error="category.{{ $locale }}" help="Ex. : Back-end, Front-end, Base de données">
            <input id="category-{{ $locale }}" type="text" wire:model="category.{{ $locale }}" class="admin-input">
        </x-admin.field>
        <x-admin.toggle label="Afficher sur l'accueil" :checked="$showOnHome" wire:click="$toggle('showOnHome')" />
    </x-slot:form>
</x-admin.crud>
