@props(['title', 'subtitle' => null, 'addLabel', 'showForm' => false, 'editing' => false, 'locale' => 'fr', 'formTitle' => null])

<div>
    <x-admin.page-header :title="$title" :subtitle="$subtitle">
        <x-slot:actions>
            <button type="button" wire:click="create" class="admin-btn bg-lime text-ink hover:bg-[#b9ff2e]">+ {{ $addLabel }}</button>
        </x-slot:actions>
    </x-admin.page-header>

    <div @class(['grid items-start gap-6', 'xl:grid-cols-[minmax(0,1fr)_400px]' => $showForm])>
        <div class="min-w-0">
            {{ $list }}
            <p class="admin-help mt-4">Glissez les éléments par la poignée pour changer l'ordre d'affichage sur le site.</p>
        </div>

        @if ($showForm)
            <section class="admin-card xl:sticky xl:top-6" aria-labelledby="crud-form-title">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h2 id="crud-form-title" class="font-display text-xl font-bold">{{ $formTitle ?? ($editing ? 'Modifier' : 'Ajouter') }}</h2>
                    <button type="button" wire:click="cancel" class="grid size-10 cursor-pointer place-items-center rounded-full hover:bg-mist" aria-label="Fermer le formulaire">×</button>
                </div>
                <x-admin.lang-tabs :current="$locale" />
                <form wire:submit="save" class="flex flex-col gap-4">
                    {{ $form }}
                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="admin-btn bg-ink text-white">Enregistrer</button>
                        <button type="button" wire:click="cancel" class="admin-btn bg-mist text-ink">Annuler</button>
                    </div>
                </form>
            </section>
        @endif
    </div>
</div>
