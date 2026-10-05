<div>
    <x-admin.page-header title="Profil et CV" subtitle="Informations affichées en haut de l'accueil et dans le pied de page">
        <x-slot:actions>
            <a href="{{ route('home') }}" target="_blank" class="admin-btn bg-mist text-ink hover:bg-line">Voir le site ↗</a>
            <button type="submit" form="profile-form" class="admin-btn bg-ink text-white" wire:loading.attr="disabled" wire:target="save">Enregistrer</button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.lang-tabs :current="$locale" />

    <form id="profile-form" wire:submit="save" class="grid items-start gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
        <div class="flex flex-col gap-6">
            <section class="admin-card">
                <h2 class="admin-card-title">Présentation</h2>
                <div class="flex flex-col gap-5">
                    @if ($locale === 'fr')
                        <x-admin.field label="Nom affiché" for="displayName">
                            <input id="displayName" type="text" wire:model="displayName" class="admin-input">
                        </x-admin.field>
                    @endif
                    <x-admin.field label="Titre ({{ strtoupper($locale) }})" for="headline-{{ $locale }}" error="headline.{{ $locale }}" help="Exemple : Développeur full stack C# .NET / Angular">
                        <input id="headline-{{ $locale }}" type="text" wire:model="headline.{{ $locale }}" class="admin-input">
                    </x-admin.field>
                    <div class="grid gap-4 md:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
                        <x-admin.field label="Titre d'accueil ({{ strtoupper($locale) }})" for="tagline-{{ $locale }}" error="tagline.{{ $locale }}">
                            <input id="tagline-{{ $locale }}" type="text" wire:model="tagline.{{ $locale }}" class="admin-input">
                        </x-admin.field>
                        <x-admin.field label="Partie surlignée" for="highlight-{{ $locale }}" error="taglineHighlight.{{ $locale }}" help="Affichée en vert citron à la fin du titre">
                            <input id="highlight-{{ $locale }}" type="text" wire:model="taglineHighlight.{{ $locale }}" class="admin-input">
                        </x-admin.field>
                    </div>
                    <x-admin.field label="Présentation ({{ strtoupper($locale) }})" for="bio-{{ $locale }}" error="bio.{{ $locale }}" help="2 à 3 phrases, 600 caractères maximum">
                        <textarea id="bio-{{ $locale }}" rows="4" wire:model="bio.{{ $locale }}" class="admin-input"></textarea>
                    </x-admin.field>
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Disponibilité</h2>
                <div class="flex flex-col gap-4">
                    <x-admin.toggle label="Afficher la mention de disponibilité sur l'accueil" :checked="$isAvailable" wire:click="toggleAvailability" />
                    <x-admin.field label="Libellé ({{ strtoupper($locale) }})" for="availability-{{ $locale }}" error="availabilityLabel.{{ $locale }}">
                        <input id="availability-{{ $locale }}" type="text" wire:model="availabilityLabel.{{ $locale }}" class="admin-input">
                    </x-admin.field>
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Coordonnées et réseaux</h2>
                <div class="grid gap-5 md:grid-cols-2">
                    <x-admin.field label="E-mail" for="email"><input id="email" type="email" wire:model="email" class="admin-input"></x-admin.field>
                    <x-admin.field label="Ville" for="city"><input id="city" type="text" wire:model="city" class="admin-input"></x-admin.field>
                    <x-admin.field label="Téléphone" for="phone" help="Affiché dans la section contact"><input id="phone" type="tel" wire:model="phone" class="admin-input"></x-admin.field>
                    <x-admin.field label="WhatsApp" for="whatsapp" help="Format international, ex. +237 6XX XX XX XX"><input id="whatsapp" type="tel" wire:model="whatsapp" class="admin-input"></x-admin.field>
                    <x-admin.field label="Lien GitHub" for="githubUrl"><input id="githubUrl" type="url" wire:model="githubUrl" class="admin-input" placeholder="https://github.com/…"></x-admin.field>
                    <x-admin.field label="Lien LinkedIn" for="linkedinUrl"><input id="linkedinUrl" type="url" wire:model="linkedinUrl" class="admin-input" placeholder="https://www.linkedin.com/in/…"></x-admin.field>
                </div>
            </section>
        </div>

        <div class="flex flex-col gap-6">
            <section class="admin-card">
                <h2 class="admin-card-title">Photo</h2>
                <div class="mx-auto mb-4 grid size-40 place-items-center overflow-hidden rounded-full bg-lilac">
                    @if ($photo?->isPreviewable())
                        <img src="{{ $photo->temporaryUrl() }}" alt="Aperçu de la nouvelle photo" class="size-full object-cover">
                    @elseif ($currentPhoto)
                        <img src="{{ $currentPhoto->hasGeneratedConversion('md') ? $currentPhoto->getUrl('md') : $currentPhoto->getUrl() }}" alt="Photo actuelle" class="size-full object-cover">
                    @else
                        <span class="text-sm font-semibold text-[#4a1aa8]">Aucune photo</span>
                    @endif
                </div>
                <x-admin.field label="Nouvelle photo" for="photo" help="JPEG, PNG ou WebP, 8 Mo maximum. Recadrée en carré.">
                    <input id="photo" type="file" wire:model="photo" accept="image/jpeg,image/png,image/webp" class="admin-input file:mr-3 file:rounded-full file:border-0 file:bg-mist file:px-4 file:py-2 file:font-semibold">
                </x-admin.field>
                <p wire:loading wire:target="photo" class="admin-help mt-2">Envoi en cours…</p>
                @if ($currentPhoto && ! $photo)
                    <button type="button" wire:click="removePhoto" wire:confirm="Supprimer la photo de profil ?" class="mt-3 cursor-pointer text-sm font-semibold text-danger hover:underline">Supprimer la photo</button>
                @endif
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">CV</h2>
                @if ($currentCv)
                    <p class="mb-4 text-[15px]">
                        <a href="{{ route('cv.download') }}" target="_blank" class="admin-link">CV actuel (PDF) ↗</a><br>
                        <span class="admin-help">Mis à jour le {{ $profile->cv_updated_at?->locale('fr')->translatedFormat('j F Y') }} · {{ number_format($currentCv->size / 1024, 0, ',', ' ') }} Ko</span>
                    </p>
                @else
                    <p class="mb-4 text-[15px] text-muted">Aucun CV envoyé : le lien de téléchargement est masqué sur le site.</p>
                @endif
                <x-admin.field label="Remplacer le CV" for="cv" help="PDF uniquement, 5 Mo maximum.">
                    <input id="cv" type="file" wire:model="cv" accept="application/pdf" class="admin-input file:mr-3 file:rounded-full file:border-0 file:bg-mist file:px-4 file:py-2 file:font-semibold">
                </x-admin.field>
                <p wire:loading wire:target="cv" class="admin-help mt-2">Envoi en cours…</p>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Projet phare</h2>
                <x-admin.field label="Projet affiché en haut de l'accueil" for="featuredProjectId">
                    <select id="featuredProjectId" wire:model="featuredProjectId" class="admin-input">
                        <option value="">Aucun</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </x-admin.field>
            </section>
        </div>
    </form>
</div>
