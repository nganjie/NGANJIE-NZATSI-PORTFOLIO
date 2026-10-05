<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\OrderedCrud;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Title;

#[Title('Technologies')]
class Technologies extends OrderedCrud
{
    public string $name = '';

    /** @var array{fr: string, en: string} */
    public array $category = ['fr' => '', 'en' => ''];

    public bool $showOnHome = false;

    protected function orderedModel(): string
    {
        return Technology::class;
    }

    protected function itemLabel(): string
    {
        return 'technologie';
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('technologies', 'name')->ignore($this->editingId)],
            'category.fr' => ['required', 'string', 'max:50'],
            'category.en' => ['nullable', 'string', 'max:50'],
            'showOnHome' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return ['name' => 'nom', 'category.fr' => 'catégorie'];
    }

    protected function resetFields(): void
    {
        $this->name = '';
        $this->category = $this->emptyTranslation();
        $this->showOnHome = false;
    }

    protected function fillFields(Model $record): void
    {
        $this->name = $record->name;
        $this->category = $this->translationsOf($record, 'category');
        $this->showOnHome = $record->show_on_home;
    }

    protected function attributesToSave(): array
    {
        return [
            'name' => $this->name,
            'category' => $this->cleanTranslation($this->category),
            'show_on_home' => $this->showOnHome,
        ];
    }

    public function toggleHome(int $id): void
    {
        $technology = Technology::query()->findOrFail($id);
        $technology->update(['show_on_home' => ! $technology->show_on_home]);
    }

    public function render(): View
    {
        $items = Technology::query()->ordered()->withCount('projects')->get();

        return view('livewire.admin.technologies', [
            'items' => $items,
            'homeCount' => $items->where('show_on_home', true)->count(),
        ]);
    }
}
