<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\OrderedCrud;
use App\Models\SkillDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Livewire\Attributes\Title;

#[Title('Compétences')]
class Skills extends OrderedCrud
{
    /** @var array{fr: string, en: string} */
    public array $title = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $description = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $tags = ['fr' => '', 'en' => ''];

    protected function orderedModel(): string
    {
        return SkillDomain::class;
    }

    protected function itemLabel(): string
    {
        return 'domaine';
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title.fr' => ['required', 'string', 'max:80'],
            'title.en' => ['nullable', 'string', 'max:80'],
            'description.fr' => ['required', 'string', 'max:300'],
            'description.en' => ['nullable', 'string', 'max:300'],
            'tags.fr' => ['required', 'string', 'max:600'],
            'tags.en' => ['nullable', 'string', 'max:600'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return ['title.fr' => 'titre', 'description.fr' => 'description', 'tags.fr' => 'étiquettes'];
    }

    protected function resetFields(): void
    {
        $this->title = $this->description = $this->tags = $this->emptyTranslation();
    }

    protected function fillFields(Model $record): void
    {
        $this->title = $this->translationsOf($record, 'title');
        $this->description = $this->translationsOf($record, 'description');
        $this->tags = $this->translationsOf($record, 'tags');
    }

    protected function attributesToSave(): array
    {
        return [
            'title' => $this->cleanTranslation($this->title),
            'description' => $this->cleanTranslation($this->description),
            'tags' => $this->cleanTranslation($this->tags),
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.skills', ['items' => $this->items()]);
    }
}
