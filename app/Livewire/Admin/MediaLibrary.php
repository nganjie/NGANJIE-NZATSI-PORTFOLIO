<?php

namespace App\Livewire\Admin;

use App\Models\Profile;
use App\Models\Project;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Title('Médias')]
class MediaLibrary extends Component
{
    public ?int $editingId = null;

    public string $alt = '';

    public string $caption = '';

    public function edit(int $id): void
    {
        $media = Media::query()->findOrFail($id);

        $this->editingId = $id;
        $this->alt = (string) $media->getCustomProperty('alt.fr', '');
        $this->caption = (string) $media->getCustomProperty('caption.fr', '');
    }

    public function save(): void
    {
        $this->validate([
            'alt' => ['nullable', 'string', 'max:200'],
            'caption' => ['nullable', 'string', 'max:200'],
        ]);

        $media = Media::query()->findOrFail($this->editingId);
        $media->setCustomProperty('alt.fr', $this->alt);
        $media->setCustomProperty('caption.fr', $this->caption);
        $media->save();
        $media->model?->touch();

        $this->editingId = null;
        $this->dispatch('notify', message: 'Image mise à jour.');
    }

    public function delete(int $id): void
    {
        $media = Media::query()->findOrFail($id);
        $owner = $media->model;
        $media->delete();
        $owner?->touch();

        $this->editingId = null;
        $this->dispatch('notify', message: 'Fichier supprimé.');
    }

    public function render(): View
    {
        $media = Media::query()
            ->whereIn('model_type', [Project::class, Profile::class])
            ->with('model')
            ->latest()
            ->get();

        return view('livewire.admin.media-library', [
            'images' => $media->filter(fn (Media $item) => str_starts_with($item->mime_type, 'image/')),
            'documents' => $media->reject(fn (Media $item) => str_starts_with($item->mime_type, 'image/')),
            'totalSize' => $media->sum('size'),
        ]);
    }
}
