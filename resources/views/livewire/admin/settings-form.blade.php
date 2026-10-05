<div>
    <x-admin.page-header title="Paramètres" subtitle="Référencement, sections de l'accueil et sécurité du compte" />

    <div class="grid items-start gap-6 xl:grid-cols-2">
        <form wire:submit="save" class="flex flex-col gap-6">
            <section class="admin-card">
                <h2 class="admin-card-title">Référencement par défaut</h2>
                <div class="flex flex-col gap-5">
                    <x-admin.field label="Titre du site" for="seoTitle" :help="mb_strlen($seoTitle).' / 60 caractères conseillés. Utilisé pour l\'accueil.'">
                        <input id="seoTitle" type="text" wire:model.live.debounce.400ms="seoTitle" class="admin-input">
                    </x-admin.field>
                    <x-admin.field label="Description par défaut" for="seoDescription" :help="mb_strlen($seoDescription).' / 160 caractères conseillés.'">
                        <textarea id="seoDescription" rows="3" wire:model.live.debounce.400ms="seoDescription" class="admin-input"></textarea>
                    </x-admin.field>
                    <x-admin.field label="Image de partage (réseaux sociaux)" for="shareImage" help="1200 × 630 px conseillé. Utilisée quand une page n'a pas d'image propre.">
                        @if ($shareImage?->isPreviewable())
                            <img src="{{ $shareImage->temporaryUrl() }}" alt="Aperçu" class="mb-2 aspect-[1200/630] w-full rounded-lg object-cover">
                        @elseif ($currentShareImage)
                            <img src="{{ $currentShareImage->getUrl() }}" alt="Image de partage actuelle" class="mb-2 aspect-[1200/630] w-full rounded-lg object-cover">
                        @endif
                        <input id="shareImage" type="file" wire:model="shareImage" accept="image/jpeg,image/png,image/webp" class="admin-input file:mr-3 file:rounded-full file:border-0 file:bg-mist file:px-4 file:py-2 file:font-semibold">
                    </x-admin.field>
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Sections de l'accueil</h2>
                <p class="admin-help -mt-3 mb-4">Une section masquée disparaît de la page et du menu.</p>
                <ul class="flex flex-col gap-1">
                    @foreach (\App\Support\Settings::SECTIONS as $key => $label)
                        <li><x-admin.toggle :label="$label" :checked="in_array($key, $sections, true)" wire:click="toggleSection('{{ $key }}')" /></li>
                    @endforeach
                </ul>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title">Notifications</h2>
                <x-admin.field label="E-mail qui reçoit les messages du formulaire" for="notifyEmail" help="Vide : l'e-mail du profil est utilisé.">
                    <input id="notifyEmail" type="email" wire:model="notifyEmail" class="admin-input">
                </x-admin.field>
            </section>

            <button type="submit" class="admin-btn self-start bg-ink text-white">Enregistrer les paramètres</button>
        </form>

        <form wire:submit="updatePassword" class="admin-card flex flex-col gap-5">
            <h2 class="font-display text-xl font-bold">Mot de passe</h2>
            <x-admin.field label="Mot de passe actuel" for="currentPassword">
                <input id="currentPassword" type="password" wire:model="currentPassword" autocomplete="current-password" class="admin-input">
            </x-admin.field>
            <x-admin.field label="Nouveau mot de passe" for="newPassword" help="12 caractères minimum, avec des lettres et des chiffres.">
                <input id="newPassword" type="password" wire:model="newPassword" autocomplete="new-password" class="admin-input">
            </x-admin.field>
            <x-admin.field label="Confirmer le nouveau mot de passe" for="newPassword_confirmation">
                <input id="newPassword_confirmation" type="password" wire:model="newPassword_confirmation" autocomplete="new-password" class="admin-input">
            </x-admin.field>
            <button type="submit" class="admin-btn self-start bg-violet text-white">Changer le mot de passe</button>
        </form>
    </div>
</div>
