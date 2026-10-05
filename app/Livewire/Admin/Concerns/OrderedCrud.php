<?php

namespace App\Livewire\Admin\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

/**
 * Base for the admin screens that manage a simple ordered list
 * (list + side panel form + delete with confirmation).
 */
abstract class OrderedCrud extends Component
{
    use EditsTranslations, ManagesOrderedList;

    public ?int $editingId = null;

    public bool $showForm = false;

    /**
     * Reset the form fields to their empty state.
     */
    abstract protected function resetFields(): void;

    /**
     * Load the form fields from an existing record.
     */
    abstract protected function fillFields(Model $record): void;

    /**
     * Attributes to persist from the form fields.
     *
     * @return array<string, mixed>
     */
    abstract protected function attributesToSave(): array;

    abstract protected function itemLabel(): string;

    public function create(): void
    {
        $this->resetValidation();
        $this->resetFields();
        $this->editingId = null;
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $this->fillFields($this->orderedModel()::query()->findOrFail($id));
        $this->editingId = $id;
        $this->showForm = true;
    }

    public function cancel(): void
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $model = $this->orderedModel();
        $record = $this->editingId ? $model::query()->findOrFail($this->editingId) : new $model;
        $record->fill($this->attributesToSave())->save();

        $this->dispatch('notify', message: ucfirst($this->itemLabel()).($this->editingId ? ' modifié(e).' : ' ajouté(e).'));
        $this->cancel();
    }

    public function delete(int $id): void
    {
        $this->orderedModel()::query()->findOrFail($id)->delete();

        if ($this->editingId === $id) {
            $this->cancel();
        }

        $this->dispatch('notify', message: ucfirst($this->itemLabel()).' supprimé(e).');
    }

    /**
     * @return Collection<int, Model>
     */
    protected function items(): Collection
    {
        return $this->orderedModel()::query()->ordered()->get();
    }
}
