<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Messages')]
class Messages extends Component
{
    #[Url(except: 'inbox')]
    public string $folder = 'inbox';

    #[Url(as: 'message')]
    public ?int $selectedId = null;

    public function mount(): void
    {
        if ($this->selectedId) {
            $this->open($this->selectedId);
        }
    }

    public function showFolder(string $folder): void
    {
        $this->folder = $folder === 'archived' ? 'archived' : 'inbox';
        $this->selectedId = null;
    }

    public function open(int $id): void
    {
        $message = Message::query()->find($id);

        if ($message === null) {
            $this->selectedId = null;

            return;
        }

        if (! $message->isRead()) {
            $message->update(['read_at' => now()]);
        }

        $this->folder = $message->archived_at ? 'archived' : 'inbox';
        $this->selectedId = $id;
    }

    public function markUnread(int $id): void
    {
        Message::query()->whereKey($id)->update(['read_at' => null]);
        $this->selectedId = null;
        $this->dispatch('notify', message: 'Message marqué comme non lu.');
    }

    public function toggleArchive(int $id): void
    {
        $message = Message::query()->findOrFail($id);
        $message->update(['archived_at' => $message->archived_at ? null : now()]);
        $this->selectedId = null;
        $this->dispatch('notify', message: $message->archived_at ? 'Message archivé.' : 'Message replacé dans la boîte de réception.');
    }

    public function delete(int $id): void
    {
        Message::query()->findOrFail($id)->delete();
        $this->selectedId = null;
        $this->dispatch('notify', message: 'Message supprimé.');
    }

    public function render(): View
    {
        $messages = Message::query()
            ->when($this->folder === 'archived', fn ($query) => $query->archived(), fn ($query) => $query->inbox())
            ->latest()
            ->get();

        return view('livewire.admin.messages', [
            'messages' => $messages,
            'selected' => $this->selectedId ? Message::query()->find($this->selectedId) : null,
            'unreadCount' => Message::query()->inbox()->unread()->count(),
            'archivedCount' => Message::query()->archived()->count(),
        ]);
    }
}
