<div>
    <x-admin.page-header title="Médias" :subtitle="$images->count().' images · '.number_format($totalSize / 1048576, 1, ',', ' ').' Mo au total'" />

    <p class="mb-6 max-w-3xl text-[15px] text-muted">
        Les images s'ajoutent depuis la fiche d'un projet (couverture, galerie) ou depuis le profil (photo). Chaque image est compressée et déclinée en plusieurs tailles (WebP) pour un affichage rapide, même sur mobile.
    </p>

    @if ($images->isEmpty())
        <x-admin.empty-state title="Aucune image pour le moment">
            <a href="{{ route('admin.projects.index') }}" wire:navigate class="admin-link">Ajouter des captures à un projet</a>
        </x-admin.empty-state>
    @else
        <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
            @foreach ($images as $image)
                <li wire:key="media-{{ $image->id }}" class="admin-card p-3!">
                    <img src="{{ $image->hasGeneratedConversion('thumb') ? $image->getUrl('thumb') : ($image->hasGeneratedConversion('sm') ? $image->getUrl('sm') : $image->getUrl()) }}" alt="" class="mb-3 h-40 w-full rounded-lg bg-mist object-cover">
                    <p class="truncate text-sm font-semibold">{{ $image->name }}</p>
                    <p class="text-[13px] text-muted">
                        @if ($image->getCustomProperty('width')){{ $image->getCustomProperty('width') }} × {{ $image->getCustomProperty('height') }} · @endif{{ number_format($image->size / 1024, 0, ',', ' ') }} Ko
                    </p>
                    <p class="mt-1 text-[13px] text-muted">
                        @if ($image->model instanceof \App\Models\Project)
                            {{ $image->collection_name === 'cover' ? 'Couverture' : 'Galerie' }} de <a href="{{ route('admin.projects.edit', $image->model) }}" wire:navigate class="admin-link">{{ $image->model->title }}</a>
                        @else
                            {{ ['photo' => 'Photo de profil', 'share_image' => 'Image de partage'][$image->collection_name] ?? 'Profil' }}
                        @endif
                    </p>

                    @if ($editingId === $image->id)
                        <form wire:submit="save" class="mt-3 flex flex-col gap-2">
                            <label for="alt-{{ $image->id }}" class="admin-help">Texte alternatif</label>
                            <input id="alt-{{ $image->id }}" type="text" wire:model="alt" class="admin-input py-2">
                            <label for="caption-{{ $image->id }}" class="admin-help">Légende</label>
                            <input id="caption-{{ $image->id }}" type="text" wire:model="caption" class="admin-input py-2">
                            <div class="flex gap-2">
                                <button type="submit" class="admin-btn admin-btn-sm bg-ink text-white">Enregistrer</button>
                                <button type="button" wire:click="$set('editingId', null)" class="admin-btn admin-btn-sm bg-mist text-ink">Annuler</button>
                            </div>
                        </form>
                    @else
                        <p class="mt-2 line-clamp-2 text-[13px] italic">{{ $image->getCustomProperty('alt.fr') ?: 'Pas de texte alternatif' }}</p>
                        <div class="mt-3 flex gap-4">
                            <button type="button" wire:click="edit({{ $image->id }})" class="admin-link text-sm">Modifier</button>
                            <button type="button" wire:click="delete({{ $image->id }})" wire:confirm="Supprimer cette image ? Elle disparaîtra aussi du site." class="cursor-pointer text-sm text-danger hover:underline">Supprimer</button>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    @if ($documents->isNotEmpty())
        <h2 class="mt-10 mb-4 font-display text-xl font-bold">Documents</h2>
        <ul class="admin-card flex flex-col gap-2 text-[15px]">
            @foreach ($documents as $document)
                <li class="flex justify-between gap-4"><span>{{ $document->file_name }} ({{ $document->collection_name === 'cv' ? 'CV' : $document->collection_name }})</span><span class="text-muted">{{ number_format($document->size / 1024, 0, ',', ' ') }} Ko</span></li>
            @endforeach
        </ul>
    @endif
</div>
