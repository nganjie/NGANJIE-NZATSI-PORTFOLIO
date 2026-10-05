<div>
    <x-admin.page-header title="Tableau de bord" :subtitle="'Bonjour '.\Illuminate\Support\Str::before($profile->display_name, ' ')">
        <x-slot:actions>
            <a href="{{ route('admin.projects.create') }}" wire:navigate class="admin-btn bg-lime text-ink hover:bg-[#b9ff2e]">+ Nouveau projet</a>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="mb-6 grid grid-cols-2 gap-4 xl:grid-cols-4">
        @foreach ([
            ['Messages non lus', $unreadCount, route('admin.messages')],
            ['Projets publiés', $publishedCount, route('admin.projects.index')],
            ['Brouillons', $draftCount, route('admin.projects.index', ['status' => 'draft'])],
            ['Visites ce mois-ci', $monthViews, null],
        ] as [$label, $value, $href])
            <div class="admin-card relative">
                <p class="mb-2 text-sm text-muted">{{ $label }}</p>
                <p class="font-display text-[44px] leading-none font-extrabold">{{ $value }}</p>
                @if ($href)
                    <a href="{{ $href }}" wire:navigate class="absolute inset-0 rounded-2xl" aria-label="{{ $label }} : voir le détail"></a>
                @endif
            </div>
        @endforeach
    </div>

    <div class="grid items-start gap-6 xl:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)]">
        <section class="admin-card" aria-labelledby="derniers-messages">
            <div class="mb-3 flex items-center justify-between">
                <h2 id="derniers-messages" class="font-display text-[22px] font-bold">Derniers messages</h2>
                <a href="{{ route('admin.messages') }}" wire:navigate class="admin-link text-sm">Tout voir →</a>
            </div>
            @if ($latestMessages->isEmpty())
                <p class="py-6 text-muted">Aucun message pour le moment. Les messages envoyés depuis le formulaire de contact apparaîtront ici.</p>
            @else
                <ul>
                    @foreach ($latestMessages as $message)
                        <li class="border-t border-mist" wire:key="message-{{ $message->id }}">
                            <a href="{{ route('admin.messages', ['message' => $message->id]) }}" wire:navigate class="flex items-start gap-4 py-4 text-ink no-underline hover:bg-paper">
                                <span aria-hidden="true" @class(['mt-2 size-2.5 shrink-0 rounded-full', 'bg-violet' => ! $message->isRead(), 'bg-transparent' => $message->isRead()])></span>
                                <span class="min-w-0 flex-1">
                                    <span class="flex justify-between gap-3">
                                        <strong @class(['font-bold' => ! $message->isRead(), 'font-medium' => $message->isRead()])>{{ $message->name }}</strong>
                                        <span class="shrink-0 text-sm text-muted">{{ $message->created_at->locale('fr')->diffForHumans() }}</span>
                                    </span>
                                    <span class="mt-0.5 block text-sm text-muted">{{ $message->type->label() }} — {{ $message->excerpt(80) }}</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <div class="flex flex-col gap-6">
            <section class="rounded-2xl bg-ink p-7 text-white" aria-labelledby="etat-site">
                <h2 id="etat-site" class="mb-5 font-display text-[22px] font-bold">État du site</h2>
                <dl class="flex flex-col gap-3.5 text-[15px]">
                    <div class="flex justify-between gap-3"><dt class="text-muted-dark">Mention de disponibilité</dt><dd @class(['font-semibold', 'text-lime' => $profile->is_available])>{{ $profile->is_available ? 'Affichée' : 'Masquée' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-muted-dark">Projets à la une</dt><dd class="font-semibold">{{ $featuredCount }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-muted-dark">Photo de profil</dt><dd @class(['font-semibold', 'text-[#ffb86b]' => ! $profile->getFirstMedia('photo')])>{{ $profile->getFirstMedia('photo') ? 'Présente' : 'Manquante' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-muted-dark">CV</dt><dd @class(['font-semibold', 'text-[#ffb86b]' => ! $profile->hasCv()])>{{ $profile->hasCv() ? 'Mis à jour le '.$profile->cv_updated_at?->locale('fr')->translatedFormat('j M Y') : 'Manquant' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-muted-dark">CV téléchargé ce mois-ci</dt><dd class="font-semibold">{{ $cvDownloads }} fois</dd></div>
                </dl>
                <a href="{{ route('admin.profile') }}" wire:navigate class="admin-btn mt-7 w-full bg-lime text-ink">Modifier le profil</a>
            </section>

            <section class="admin-card" aria-labelledby="projets-vus">
                <h2 id="projets-vus" class="mb-3 font-display text-lg font-bold">Projets les plus vus (30 jours)</h2>
                @if ($topProjects->isEmpty())
                    <p class="text-sm text-muted">Pas encore de visite enregistrée.</p>
                @else
                    <ol class="flex flex-col gap-2 text-[15px]">
                        @foreach ($topProjects as $project)
                            <li class="flex justify-between gap-3"><span>{{ $project->title }}</span><span class="font-semibold">{{ $project->page_views_count }}</span></li>
                        @endforeach
                    </ol>
                @endif
                <p class="admin-help mt-4">Les visites des administrateurs et des robots ne sont pas comptées.</p>
            </section>
        </div>
    </div>
</div>
