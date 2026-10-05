@php($L = strtoupper($locale))

<div>
    <x-admin.page-header :title="$project ? $project->title : 'Nouveau projet'">
        <x-slot:breadcrumb>
            <a href="{{ route('admin.projects.index') }}" wire:navigate class="text-muted hover:text-violet">Projets</a> / {{ $project ? 'Modifier' : 'Créer' }}
        </x-slot:breadcrumb>
        <x-slot:actions>
            @if ($project)
                <a href="{{ route('projects.show', $project) }}" target="_blank" class="admin-btn bg-mist text-ink hover:bg-line">Aperçu ↗</a>
            @endif
            <button type="submit" form="project-form" class="admin-btn bg-ink text-white" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save">Enregistrer</span>
                <span wire:loading wire:target="save">Enregistrement…</span>
            </button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.lang-tabs :current="$locale" />

    @if ($errors->any())
        <div role="alert" class="mb-6 rounded-xl bg-[#fde8e8] p-4 text-[15px] text-danger">
            Le projet n'a pas été enregistré : {{ $errors->count() }} {{ \Illuminate\Support\Str::plural('champ', $errors->count()) }} à corriger.
            @if ($errors->has('title.fr') || $errors->has('summary.fr'))
                Pensez à remplir la version française.
            @endif
        </div>
    @endif

    <form id="project-form" wire:submit="save" class="grid items-start gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
        <div class="flex min-w-0 flex-col gap-6">
            <section class="admin-card">
                <h2 class="admin-card-title">Informations</h2>
                <div class="flex flex-col gap-5">
                    <x-admin.field label="Titre ({{ $L }})" for="title-{{ $locale }}" error="title.{{ $locale }}">
                        <input id="title-{{ $locale }}" type="text" wire:model.blur="title.{{ $locale }}" class="admin-input">
                    </x-admin.field>
                    <x-admin.field label="Adresse de la page" for="slug" :help="url('/projets').'/'.($slug ?: '…')">
                        <input id="slug" type="text" wire:model.blur="slug" class="admin-input">
                    </x-admin.field>
                    <x-admin.field label="Résumé ({{ $L }})" for="summary-{{ $locale }}" error="summary.{{ $locale }}" help="Une ou deux phrases, affichées sur les cartes et en description de la page.">
                        <textarea id="summary-{{ $locale }}" rows="3" wire:model="summary.{{ $locale }}" class="admin-input"></textarea>
                    </x-admin.field>
                    <div class="grid gap-4 md:grid-cols-2">
                        <x-admin.field label="Rôle ({{ $L }})" for="role-{{ $locale }}" error="role.{{ $locale }}">
                            <input id="role-{{ $locale }}" type="text" wire:model="role.{{ $locale }}" class="admin-input">
                        </x-admin.field>
                        <x-admin.field label="Contexte ({{ $L }})" for="context-{{ $locale }}" error="context.{{ $locale }}" help="Ex. : SIGP SC Cameroun, en équipe">
                            <input id="context-{{ $locale }}" type="text" wire:model="context.{{ $locale }}" class="admin-input">
                        </x-admin.field>
                        <x-admin.field label="Période ({{ $L }})" for="period-{{ $locale }}" error="period.{{ $locale }}" help="Texte libre : « Depuis février 2024 »">
                            <input id="period-{{ $locale }}" type="text" wire:model="period.{{ $locale }}" class="admin-input">
                        </x-admin.field>
                        <x-admin.field label="Étiquettes ({{ $L }})" for="tags-{{ $locale }}" error="tags.{{ $locale }}" help="Une par ligne : Fintech, Éducation…">
                            <textarea id="tags-{{ $locale }}" rows="2" wire:model="tags.{{ $locale }}" class="admin-input"></textarea>
                        </x-admin.field>
                        <x-admin.field label="Lien du site en ligne" for="demoUrl">
                            <input id="demoUrl" type="url" wire:model="demoUrl" class="admin-input" placeholder="https://…">
                        </x-admin.field>
                        <x-admin.field label="Lien du dépôt (facultatif)" for="repositoryUrl">
                            <input id="repositoryUrl" type="url" wire:model="repositoryUrl" class="admin-input" placeholder="https://github.com/…">
                        </x-admin.field>
                    </div>
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Étude de cas</h2>
                <p class="admin-label mb-2" id="case-study-label">Le projet en détail ({{ $L }})</p>
                <div wire:ignore wire:key="trix-{{ $locale }}"
                    x-data
                    x-on:trix-change="$wire.set('caseStudy.{{ $locale }}', $event.target.value, false)">
                    <input id="case-study-{{ $locale }}" type="hidden" value="{{ $caseStudy[$locale] }}">
                    <trix-editor input="case-study-{{ $locale }}" aria-labelledby="case-study-label" class="prose-case"></trix-editor>
                </div>
                @error('caseStudy.'.$locale)<p class="mt-2 text-sm text-danger">{{ $message }}</p>@enderror

                <div class="mt-8 mb-3 flex items-center justify-between gap-4">
                    <p class="admin-label">Ce que j'ai fait</p>
                    <button type="button" wire:click="addTask" class="admin-link min-h-11 text-sm">+ Ajouter une étape</button>
                </div>
                @if (empty($tasks))
                    <p class="rounded-xl bg-paper p-4 text-sm text-muted">Aucune étape. Ajoutez les grandes réalisations du projet : elles s'affichent numérotées sur la page.</p>
                @else
                    <ol class="flex flex-col gap-3" wire:sort="sortTask">
                        @foreach ($tasks as $index => $task)
                            <li wire:key="task-{{ $task['id'] ?? 'new-'.$index }}" wire:sort:item="{{ $index }}" class="rounded-xl border border-line p-4">
                                <div class="mb-3 flex items-center gap-3">
                                    <x-admin.sort-handle up="moveTask({{ $index }}, -1)" down="moveTask({{ $index }}, 1)" label="l'étape {{ $index + 1 }}" />
                                    <span class="grid size-8 shrink-0 place-items-center rounded-full bg-lime font-display text-[13px] font-extrabold">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <label for="task-title-{{ $index }}" class="sr-only">Titre de l'étape {{ $index + 1 }}</label>
                                    <input id="task-title-{{ $index }}" type="text" wire:model="tasks.{{ $index }}.title.{{ $locale }}" class="admin-input flex-1" placeholder="Titre ({{ $L }})">
                                    <button type="button" wire:click="removeTask({{ $index }})" wire:confirm="Retirer cette étape ?" class="grid size-11 shrink-0 cursor-pointer place-items-center rounded-full text-danger hover:bg-[#fde8e8]" aria-label="Retirer l'étape {{ $index + 1 }}">×</button>
                                </div>
                                <label for="task-body-{{ $index }}" class="sr-only">Description de l'étape {{ $index + 1 }}</label>
                                <textarea id="task-body-{{ $index }}" rows="2" wire:model="tasks.{{ $index }}.body.{{ $locale }}" class="admin-input" placeholder="Description ({{ $L }})"></textarea>
                                @error('tasks.'.$index.'.title.fr')<p class="mt-2 text-sm text-danger">{{ $message }}</p>@enderror
                            </li>
                        @endforeach
                    </ol>
                @endif

                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    <x-admin.field label="Enseignement retenu ({{ $L }})" for="lesson-{{ $locale }}" error="lesson.{{ $locale }}" help="Une phrase, affichée en citation.">
                        <textarea id="lesson-{{ $locale }}" rows="3" wire:model="lesson.{{ $locale }}" class="admin-input"></textarea>
                    </x-admin.field>
                    <x-admin.field label="Résultats ({{ $L }})" for="results-{{ $locale }}" error="results.{{ $locale }}" help="Un résultat par ligne. N'indiquez que des chiffres vérifiables.">
                        <textarea id="results-{{ $locale }}" rows="3" wire:model="results.{{ $locale }}" class="admin-input"></textarea>
                    </x-admin.field>
                </div>
            </section>

            <section class="admin-card">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                    <h2 class="font-display text-xl font-bold">Galerie</h2>
                    <span class="admin-help">Images compressées et redimensionnées automatiquement</span>
                </div>

                @if ($gallery->isNotEmpty())
                    <ul class="mb-4 grid gap-4 sm:grid-cols-2" wire:sort="sortGallery">
                        @foreach ($gallery as $media)
                            <li wire:key="media-{{ $media->id }}" wire:sort:item="{{ $media->id }}" class="rounded-xl border border-line p-3">
                                <div class="relative mb-3">
                                    <img src="{{ $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl() }}" alt="" class="h-36 w-full rounded-lg object-cover">
                                    <div class="absolute top-2 left-2 rounded-full bg-white/90"><x-admin.sort-handle :label="'l\'image '.$loop->iteration" /></div>
                                    <button type="button" wire:click="deleteMedia({{ $media->id }})" wire:confirm="Supprimer cette image ?" class="absolute top-2 right-2 grid size-10 cursor-pointer place-items-center rounded-full bg-white/90 text-danger" aria-label="Supprimer l'image {{ $loop->iteration }}">×</button>
                                </div>
                                <label for="alt-{{ $media->id }}" class="admin-help">Texte alternatif</label>
                                <input id="alt-{{ $media->id }}" type="text" wire:model="galleryMeta.{{ $media->id }}.alt" class="admin-input mb-2 py-2">
                                <label for="caption-{{ $media->id }}" class="admin-help">Légende</label>
                                <input id="caption-{{ $media->id }}" type="text" wire:model="galleryMeta.{{ $media->id }}.caption" class="admin-input py-2">
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($galleryUploads)
                    <ul class="mb-4 grid grid-cols-3 gap-3">
                        @foreach ($galleryUploads as $index => $upload)
                            <li wire:key="upload-{{ $index }}" class="relative">
                                @if ($upload->isPreviewable())<img src="{{ $upload->temporaryUrl() }}" alt="Nouvelle image {{ $index + 1 }}" class="h-24 w-full rounded-lg object-cover">@endif
                                <button type="button" wire:click="removeGalleryUpload({{ $index }})" class="absolute top-1 right-1 grid size-8 cursor-pointer place-items-center rounded-full bg-white/90 text-danger" aria-label="Retirer la nouvelle image {{ $index + 1 }}">×</button>
                            </li>
                        @endforeach
                    </ul>
                    <p class="admin-help mb-3">Ces images seront ajoutées à l'enregistrement.</p>
                @endif

                <label class="flex min-h-28 cursor-pointer flex-col items-center justify-center gap-1 rounded-xl border-2 border-dashed border-line bg-paper p-4 text-center text-sm font-semibold text-muted hover:border-ink">
                    <span>+ Ajouter des images</span>
                    <span class="font-normal">JPEG, PNG ou WebP, 8 Mo maximum chacune</span>
                    <input type="file" wire:model="galleryUploads" multiple accept="image/jpeg,image/png,image/webp" class="sr-only">
                </label>
                <p wire:loading wire:target="galleryUploads" class="admin-help mt-2">Envoi en cours…</p>
                @error('galleryUploads.*')<p class="mt-2 text-sm text-danger">{{ $message }}</p>@enderror
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Référencement</h2>
                <div class="flex flex-col gap-5">
                    <x-admin.field label="Titre SEO ({{ $L }})" for="seo-title-{{ $locale }}" error="seoTitle.{{ $locale }}" :help="mb_strlen($seoTitle[$locale]).' / 60 caractères conseillés. Vide : titre du projet.'">
                        <input id="seo-title-{{ $locale }}" type="text" wire:model.live.debounce.400ms="seoTitle.{{ $locale }}" class="admin-input">
                    </x-admin.field>
                    <x-admin.field label="Description SEO ({{ $L }})" for="seo-desc-{{ $locale }}" error="seoDescription.{{ $locale }}" :help="mb_strlen($seoDescription[$locale]).' / 160 caractères conseillés. Vide : résumé.'">
                        <textarea id="seo-desc-{{ $locale }}" rows="2" wire:model.live.debounce.400ms="seoDescription.{{ $locale }}" class="admin-input"></textarea>
                    </x-admin.field>
                    <div class="rounded-xl border border-line bg-paper p-4">
                        <p class="admin-help mb-1.5">Aperçu dans les résultats de recherche</p>
                        <p class="text-lg text-[#1a0dab]">{{ ($seoTitle[$locale] ?: $title[$locale] ?: $title['fr']) ?: 'Titre du projet' }} — {{ \App\Models\Profile::current()->display_name }}</p>
                        <p class="text-[13px] text-[#1e6b2f]">{{ url('/projets').'/'.($slug ?: '…') }}</p>
                        <p class="mt-1 text-sm text-muted">{{ \Illuminate\Support\Str::limit(($seoDescription[$locale] ?: $summary[$locale] ?: $summary['fr']) ?: 'Résumé du projet', 160) }}</p>
                    </div>
                </div>
            </section>
        </div>

        <div class="flex flex-col gap-6 xl:sticky xl:top-6">
            <section class="admin-card">
                <h2 class="admin-card-title">Publication</h2>
                <div class="flex flex-col gap-4">
                    <x-admin.field label="Statut" for="status">
                        <select id="status" wire:model="status" class="admin-input">
                            @foreach (\App\Enums\ProjectStatus::cases() as $case)
                                <option value="{{ $case->value }}">{{ $case->label() }}</option>
                            @endforeach
                        </select>
                    </x-admin.field>
                    <x-admin.field label="Type" for="type">
                        <select id="type" wire:model="type" class="admin-input">
                            @foreach (\App\Enums\ProjectType::cases() as $case)
                                <option value="{{ $case->value }}">{{ $case->label() }}</option>
                            @endforeach
                        </select>
                    </x-admin.field>
                    <x-admin.toggle label="Mettre à la une sur l'accueil" :checked="$isFeatured" wire:click="toggleFeatured" />
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Image de couverture</h2>
                <div class="h-44 rounded-md p-2.5" style="background-color: {{ \App\Enums\AccentColor::from($accentColor)->hex() }}">
                    @if ($cover?->isPreviewable())
                        <img src="{{ $cover->temporaryUrl() }}" alt="Aperçu de la nouvelle couverture" class="size-full rounded-[3px] object-cover">
                    @elseif ($currentCover)
                        <img src="{{ $currentCover->hasGeneratedConversion('md') ? $currentCover->getUrl('md') : $currentCover->getUrl() }}" alt="Couverture actuelle" class="size-full rounded-[3px] object-cover">
                    @else
                        <div @class(['grid size-full place-items-center rounded-[3px] border text-xs font-semibold', 'border-white/45 text-white' => \App\Enums\AccentColor::from($accentColor)->isDark(), 'border-ink/30 text-ink' => ! \App\Enums\AccentColor::from($accentColor)->isDark()])>Pas d'image : bloc de couleur</div>
                    @endif
                </div>
                <label class="admin-btn mt-3 w-full cursor-pointer bg-mist text-ink hover:bg-line">
                    {{ $currentCover ? "Remplacer l'image" : 'Choisir une image' }}
                    <input type="file" wire:model="cover" accept="image/jpeg,image/png,image/webp" class="sr-only">
                </label>
                @if ($currentCover && ! $cover)
                    <button type="button" wire:click="deleteMedia({{ $currentCover->id }})" wire:confirm="Supprimer l'image de couverture ?" class="mt-2 w-full cursor-pointer text-sm font-semibold text-danger hover:underline">Supprimer l'image</button>
                @endif
                @error('cover')<p class="mt-2 text-sm text-danger">{{ $message }}</p>@enderror

                <p class="admin-label mt-6 mb-2.5" id="accent-label">Couleur d'accent</p>
                <div role="radiogroup" aria-labelledby="accent-label" class="flex flex-wrap gap-2.5">
                    @foreach (\App\Enums\AccentColor::cases() as $color)
                        <button type="button" role="radio" aria-checked="{{ $accentColor === $color->value ? 'true' : 'false' }}" aria-label="{{ $color->label() }}"
                            wire:click="$set('accentColor', '{{ $color->value }}')"
                            @class(['size-10 cursor-pointer rounded-full border border-line', 'ring-2 ring-ink ring-offset-2' => $accentColor === $color->value])
                            style="background-color: {{ $color->hex() }}"></button>
                    @endforeach
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Technologies</h2>
                <p class="admin-help mb-3">Cliquez pour ajouter ou retirer. L'ordre de sélection est l'ordre d'affichage.</p>
                <ul class="flex flex-wrap gap-2">
                    @foreach ($technologies as $technology)
                        @php($selected = in_array($technology->id, $technologyIds, true))
                        <li wire:key="tech-{{ $technology->id }}">
                            <button type="button" wire:click="toggleTechnology({{ $technology->id }})" aria-pressed="{{ $selected ? 'true' : 'false' }}"
                                @class(['min-h-9 cursor-pointer rounded-full border px-3 text-[13px] font-semibold', 'border-ink bg-ink text-white' => $selected, 'border-line bg-paper text-ink hover:border-ink' => ! $selected])>
                                {{ $technology->name }}@if ($selected) <span aria-hidden="true">×</span>@endif
                            </button>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('admin.technologies') }}" wire:navigate class="admin-link mt-3 inline-block text-sm">Gérer les technologies →</a>
            </section>

            @if ($project)
                <section class="admin-card border-[#f2c4c4]">
                    <h2 class="admin-card-title text-danger">Zone sensible</h2>
                    <button type="button" wire:click="delete" wire:confirm="Supprimer définitivement ce projet et ses images ?" class="admin-btn w-full border border-danger bg-white text-danger hover:bg-[#fde8e8]">Supprimer le projet</button>
                </section>
            @endif
        </div>
    </form>
</div>
