<div>
    <x-admin.page-header title="Messages" :subtitle="$unreadCount.' non '.\Illuminate\Support\Str::plural('lu', $unreadCount)">
        <x-slot:actions>
            <div role="tablist" aria-label="Dossier" class="inline-flex gap-1 rounded-full bg-mist p-1">
                <button type="button" role="tab" aria-selected="{{ $folder === 'inbox' ? 'true' : 'false' }}" wire:click="showFolder('inbox')"
                    @class(['min-h-10 cursor-pointer rounded-full px-4 font-semibold', 'bg-ink text-white' => $folder === 'inbox', 'hover:bg-white' => $folder !== 'inbox'])>Boîte de réception</button>
                <button type="button" role="tab" aria-selected="{{ $folder === 'archived' ? 'true' : 'false' }}" wire:click="showFolder('archived')"
                    @class(['min-h-10 cursor-pointer rounded-full px-4 font-semibold', 'bg-ink text-white' => $folder === 'archived', 'hover:bg-white' => $folder !== 'archived'])>Archivés ({{ $archivedCount }})</button>
            </div>
        </x-slot:actions>
    </x-admin.page-header>

    @if ($messages->isEmpty())
        <x-admin.empty-state :title="$folder === 'archived' ? 'Aucun message archivé' : 'Boîte de réception vide'">
            Les messages envoyés depuis le formulaire de contact du site arrivent ici, et une notification part par e-mail.
        </x-admin.empty-state>
    @else
        <div class="grid min-h-[600px] overflow-hidden rounded-2xl border border-line bg-white lg:grid-cols-[360px_minmax(0,1fr)]">
            <ul class="border-line lg:border-r" aria-label="Liste des messages">
                @foreach ($messages as $message)
                    @php($isSelected = $selected?->id === $message->id)
                    <li wire:key="message-{{ $message->id }}">
                        <button type="button" wire:click="open({{ $message->id }})" @if ($isSelected) aria-current="true" @endif
                            @class(['block w-full cursor-pointer border-b border-mist px-5 py-4 text-left', 'bg-[#f4f0ff] shadow-[inset_4px_0_0_#6a1bf0]' => $isSelected, 'hover:bg-paper' => ! $isSelected])>
                            <span class="flex items-center justify-between gap-3">
                                <span @class(['flex items-center gap-2', 'font-bold' => ! $message->isRead(), 'font-medium' => $message->isRead()])>
                                    <span aria-hidden="true" @class(['size-2 rounded-full', 'bg-violet' => ! $message->isRead()])></span>
                                    {{ $message->name }}
                                    @unless ($message->isRead())<span class="sr-only">(non lu)</span>@endunless
                                </span>
                                <span class="shrink-0 text-[13px] text-muted">{{ $message->created_at->locale('fr')->isoFormat('D MMM') }}</span>
                            </span>
                            <span class="mt-1.5 inline-block rounded-full bg-mist px-2.5 py-0.5 text-xs font-semibold">{{ $message->type->label() }}</span>
                            <span class="mt-1.5 block truncate text-sm text-muted">{{ $message->excerpt(70) }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="p-6 md:p-8">
                @if ($selected)
                    <article class="flex h-full flex-col gap-5" aria-labelledby="message-title">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <span class="rounded-full bg-lilac px-3 py-1 text-[13px] font-semibold text-[#2a1466]">{{ $selected->type->label() }}</span>
                                <h2 id="message-title" class="mt-3 mb-1 font-display text-[26px] font-bold">{{ $selected->name }}</h2>
                                <p class="text-[15px] text-muted"><a href="mailto:{{ $selected->email }}" class="admin-link">{{ $selected->email }}</a> · {{ $selected->created_at->locale('fr')->translatedFormat('j F Y à H:i') }}</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" wire:click="markUnread({{ $selected->id }})" class="admin-btn admin-btn-sm bg-mist text-ink">Marquer non lu</button>
                                <button type="button" wire:click="toggleArchive({{ $selected->id }})" class="admin-btn admin-btn-sm bg-mist text-ink">{{ $selected->archived_at ? 'Désarchiver' : 'Archiver' }}</button>
                                <button type="button" wire:click="delete({{ $selected->id }})" wire:confirm="Supprimer ce message ? Il sera effacé définitivement après 30 jours." class="admin-btn admin-btn-sm border border-danger bg-white text-danger">Supprimer</button>
                            </div>
                        </div>
                        <div class="border-t border-mist pt-5 whitespace-pre-line text-[#2a2a30]">{{ $selected->body }}</div>
                        <div class="mt-auto pt-4">
                            <a href="mailto:{{ $selected->email }}?subject={{ rawurlencode('Re : votre message sur le portfolio') }}" class="admin-btn bg-violet text-white">Répondre par e-mail ↗</a>
                        </div>
                    </article>
                @else
                    <div class="grid h-full place-items-center text-center text-muted">
                        <p>Sélectionnez un message pour le lire.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
