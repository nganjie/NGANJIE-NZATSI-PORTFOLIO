<div>
    <x-admin.page-header title="Projets" :subtitle="$total.' '.\Illuminate\Support\Str::plural('projet', $total)">
        <x-slot:actions>
            <a href="{{ route('admin.projects.create') }}" wire:navigate class="admin-btn bg-lime text-ink hover:bg-[#b9ff2e]">+ Nouveau projet</a>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="mb-5 flex flex-wrap gap-3">
        <label for="search" class="sr-only">Rechercher un projet</label>
        <input id="search" type="search" wire:model.live.debounce.300ms="search" placeholder="Rechercher un projet…" class="admin-input min-w-[240px] flex-1 rounded-full bg-white">
        <label for="filter-type" class="sr-only">Type</label>
        <select id="filter-type" wire:model.live="type" class="admin-input w-auto rounded-full bg-white">
            <option value="">Tous les types</option>
            @foreach (\App\Enums\ProjectType::cases() as $case)
                <option value="{{ $case->value }}">{{ $case->label() }}</option>
            @endforeach
        </select>
        <label for="filter-status" class="sr-only">Statut</label>
        <select id="filter-status" wire:model.live="status" class="admin-input w-auto rounded-full bg-white">
            <option value="">Tous les statuts</option>
            @foreach (\App\Enums\ProjectStatus::cases() as $case)
                <option value="{{ $case->value }}">{{ $case->label() }}</option>
            @endforeach
        </select>
    </div>

    @if ($projects->isEmpty())
        <x-admin.empty-state title="Aucun projet ne correspond">
            @if ($this->isFiltered())
                <button type="button" wire:click="$set('search', ''); $set('type', ''); $set('status', '')" class="admin-link">Effacer les filtres</button>
            @else
                <a href="{{ route('admin.projects.create') }}" wire:navigate class="admin-link">Créer le premier projet</a>
            @endif
        </x-admin.empty-state>
    @else
        <div class="overflow-x-auto rounded-2xl border border-line bg-white">
            <table class="admin-table w-full min-w-[820px] border-collapse text-[15px]">
                <thead>
                    <tr>
                        <th class="w-16"><span class="sr-only">Ordre</span></th>
                        <th>Projet</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>À la une</th>
                        <th class="text-right!">Actions</th>
                    </tr>
                </thead>
                <tbody @unless ($this->isFiltered()) wire:sort="sortItem" @endunless>
                    @foreach ($projects as $project)
                        <tr wire:key="project-{{ $project->id }}" @unless ($this->isFiltered()) wire:sort:item="{{ $project->id }}" @endunless>
                            <td>
                                @unless ($this->isFiltered())
                                    <x-admin.sort-handle up="moveUp({{ $project->id }})" down="moveDown({{ $project->id }})" :label="$project->title" />
                                @endunless
                            </td>
                            <td>
                                <div class="flex items-center gap-3.5">
                                    @php($cover = $project->getFirstMedia('cover'))
                                    @if ($cover)
                                        <img src="{{ $cover->hasGeneratedConversion('thumb') ? $cover->getUrl('thumb') : $cover->getUrl() }}" alt="" class="h-10 w-14 shrink-0 rounded-md object-cover">
                                    @else
                                        <span aria-hidden="true" class="h-10 w-14 shrink-0 rounded-md" style="background-color: {{ $project->accent_color->hex() }}"></span>
                                    @endif
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.projects.edit', $project) }}" wire:navigate class="font-semibold text-ink no-underline hover:text-violet">{{ $project->title }}</a>
                                        <div class="truncate text-[13px] text-muted">/projets/{{ $project->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $project->type->label() }}</td>
                            <td>
                                <button type="button" wire:click="togglePublished({{ $project->id }})" class="cursor-pointer" title="Changer le statut">
                                    <x-admin.status-badge :status="$project->status" />
                                </button>
                            </td>
                            <td>
                                <x-admin.toggle :label="'Mettre '.$project->title.' à la une'" sr-only-label :checked="$project->is_featured" wire:click="toggleFeatured({{ $project->id }})" />
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <a href="{{ route('admin.projects.edit', $project) }}" wire:navigate class="admin-link mr-4 text-sm">Modifier</a>
                                <a href="{{ route('projects.show', $project) }}" target="_blank" class="mr-4 text-sm text-muted hover:text-violet">Aperçu ↗</a>
                                <button type="button" wire:click="delete({{ $project->id }})" wire:confirm="Supprimer définitivement « {{ $project->title }} » et ses images ?" class="cursor-pointer text-sm text-danger hover:underline">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="admin-help mt-4">
            @if ($this->isFiltered())
                Effacez la recherche et les filtres pour changer l'ordre d'affichage.
            @else
                Glissez les lignes par la poignée pour changer l'ordre d'affichage sur le site. Au clavier, utilisez les boutons ↑ et ↓ qui apparaissent avec la touche Tab.
            @endif
        </p>
    @endif
</div>
