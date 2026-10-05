<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\OrderedCrud;
use App\Models\ProcessStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Livewire\Attributes\Title;

#[Title('Méthode')]
class ProcessSteps extends OrderedCrud
{
    /** @var array{fr: string, en: string} */
    public array $title = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $body = ['fr' => '', 'en' => ''];

    protected function orderedModel(): string
    {
        return ProcessStep::class;
    }

    protected function itemLabel(): string
    {
        return 'étape';
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title.fr' => ['required', 'string', 'max:40'],
            'title.en' => ['nullable', 'string', 'max:40'],
            'body.fr' => ['required', 'string', 'max:300'],
            'body.en' => ['nullable', 'string', 'max:300'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return ['title.fr' => 'titre', 'body.fr' => 'texte'];
    }

    protected function resetFields(): void
    {
        $this->title = $this->body = $this->emptyTranslation();
    }

    protected function fillFields(Model $record): void
    {
        $this->title = $this->translationsOf($record, 'title');
        $this->body = $this->translationsOf($record, 'body');
    }

    protected function attributesToSave(): array
    {
        return [
            'title' => $this->cleanTranslation($this->title),
            'body' => $this->cleanTranslation($this->body),
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.process-steps', ['items' => $this->items()]);
    }
}
