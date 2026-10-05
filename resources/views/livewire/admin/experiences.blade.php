@php($L = strtoupper($locale))

<x-admin.crud title="Parcours" subtitle="Expériences et formations, dans l'ordre d'affichage" add-label="Ajouter une ligne" :show-form="$showForm" :editing="(bool) $editingId" :locale="$locale">
    <x-slot:list>
        @if ($items->isEmpty())
            <x-admin.empty-state title="Aucune ligne de parcours" />
        @else
            <ul wire:sort="sortItem" class="rounded-2xl border border-line bg-white">
                @foreach ($items as $item)
                    <x-admin.crud-row :id="$item->id" :label="$item->title" :active="$editingId === $item->id">
                        <p class="font-semibold">
                            {{ $item->title }}
                            @if ($item->is_current)<span class="eyebrow ml-2 rounded-full bg-violet px-2 py-0.5 text-[11px] text-white">Actuel</span>@endif
                        </p>
                        <p class="truncate text-sm text-muted">{{ $item->type->label() }} · {{ $item->organization }} · {{ $item->periodLabel() }}</p>
                    </x-admin.crud-row>
                @endforeach
            </ul>
        @endif
    </x-slot:list>

    <x-slot:form>
        @if ($locale === 'fr')
            <x-admin.field label="Type" for="type">
                <select id="type" wire:model="type" class="admin-input">
                    @foreach (\App\Enums\ExperienceType::cases() as $case)
                        <option value="{{ $case->value }}">{{ $case->label() }}</option>
                    @endforeach
                </select>
            </x-admin.field>
            <x-admin.field label="Organisme" for="organization">
                <input id="organization" type="text" wire:model="organization" class="admin-input">
            </x-admin.field>
            <x-admin.field label="Ville" for="location">
                <input id="location" type="text" wire:model="location" class="admin-input">
            </x-admin.field>
        @endif
        <x-admin.field label="Intitulé ({{ $L }})" for="title-{{ $locale }}" error="title.{{ $locale }}">
            <input id="title-{{ $locale }}" type="text" wire:model="title.{{ $locale }}" class="admin-input">
        </x-admin.field>
        @if ($locale === 'fr')
            <div class="grid grid-cols-2 gap-3">
                <x-admin.field label="Début" for="startedAt"><input id="startedAt" type="date" wire:model="startedAt" class="admin-input"></x-admin.field>
                <x-admin.field label="Fin" for="endedAt"><input id="endedAt" type="date" wire:model="endedAt" class="admin-input" @disabled($ongoing)></x-admin.field>
            </div>
            <label class="flex min-h-11 items-center gap-2.5 text-[15px]"><input type="checkbox" wire:model.live="ongoing" class="size-5 accent-violet"> En cours</label>
        @endif
        <x-admin.field label="Libellé de date ({{ $L }})" for="dateLabel-{{ $locale }}" error="dateLabel.{{ $locale }}" help="Facultatif, remplace les dates : « 2021 – 2024 »">
            <input id="dateLabel-{{ $locale }}" type="text" wire:model="dateLabel.{{ $locale }}" class="admin-input">
        </x-admin.field>
        <x-admin.field label="Points clés ({{ $L }})" for="highlights-{{ $locale }}" error="highlights.{{ $locale }}" help="Un point par ligne">
            <textarea id="highlights-{{ $locale }}" rows="5" wire:model="highlights.{{ $locale }}" class="admin-input"></textarea>
        </x-admin.field>
        @if ($locale === 'fr')
            <x-admin.toggle label="Poste actuel (ligne violette)" :checked="$isCurrent" wire:click="$toggle('isCurrent')" />
            <p class="admin-help -mt-2">Un seul poste actuel à la fois : cocher celui-ci décoche les autres.</p>
        @endif
    </x-slot:form>
</x-admin.crud>
