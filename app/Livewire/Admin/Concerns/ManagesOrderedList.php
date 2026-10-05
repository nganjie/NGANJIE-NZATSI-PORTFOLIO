<?php

namespace App\Livewire\Admin\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Drag-and-drop and keyboard reordering for models using HasPosition.
 */
trait ManagesOrderedList
{
    /**
     * @return class-string<Model>
     */
    abstract protected function orderedModel(): string;

    /**
     * Handler for wire:sort (position is zero-based).
     */
    public function sortItem(int|string $item, int $position): void
    {
        $model = $this->orderedModel();
        $ids = $model::query()->ordered()->pluck('id')->reject(fn ($id) => (string) $id === (string) $item)->values()->all();

        array_splice($ids, max(0, $position), 0, [(int) $item]);

        $model::reorder($ids);
    }

    public function moveUp(int $id): void
    {
        $this->move($id, -1);
    }

    public function moveDown(int $id): void
    {
        $this->move($id, 1);
    }

    private function move(int $id, int $offset): void
    {
        $model = $this->orderedModel();
        $ids = $model::query()->ordered()->pluck('id')->all();
        $index = array_search($id, $ids, true);

        if ($index === false || ! isset($ids[$index + $offset])) {
            return;
        }

        [$ids[$index], $ids[$index + $offset]] = [$ids[$index + $offset], $ids[$index]];

        $model::reorder($ids);
    }
}
