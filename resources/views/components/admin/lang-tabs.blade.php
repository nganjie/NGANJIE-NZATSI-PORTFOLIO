@props(['current' => 'fr'])

<div class="mb-6">
    <div role="tablist" aria-label="Langue du contenu" class="inline-flex gap-1 rounded-full bg-mist p-1">
        @foreach (['fr' => 'Français', 'en' => 'English'] as $code => $label)
            <button type="button" role="tab" aria-selected="{{ $current === $code ? 'true' : 'false' }}" wire:click="$set('locale', '{{ $code }}')"
                @class(['min-h-10 cursor-pointer rounded-full px-5 font-display text-[13px] font-bold tracking-label',
                    'bg-ink text-white' => $current === $code, 'text-ink hover:bg-white' => $current !== $code])>
                {{ $label }}
            </button>
        @endforeach
    </div>
    @if ($current === 'en')
        <p class="admin-help mt-2">Version anglaise : affichée sur le site en anglais (/en). Un champ laissé vide affiche le texte français.</p>
    @endif
</div>
