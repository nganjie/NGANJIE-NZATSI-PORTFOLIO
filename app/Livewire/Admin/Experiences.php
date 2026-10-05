<?php

namespace App\Livewire\Admin;

use App\Enums\ExperienceType;
use App\Livewire\Admin\Concerns\OrderedCrud;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Title;

#[Title('Parcours')]
class Experiences extends OrderedCrud
{
    public string $type = 'job';

    public string $organization = '';

    public string $location = '';

    /** @var array{fr: string, en: string} */
    public array $title = ['fr' => '', 'en' => ''];

    public string $startedAt = '';

    public string $endedAt = '';

    public bool $ongoing = false;

    /** @var array{fr: string, en: string} */
    public array $dateLabel = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $highlights = ['fr' => '', 'en' => ''];

    public bool $isCurrent = false;

    protected function orderedModel(): string
    {
        return Experience::class;
    }

    protected function itemLabel(): string
    {
        return 'ligne de parcours';
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(ExperienceType::class)],
            'organization' => ['required', 'string', 'max:150'],
            'location' => ['nullable', 'string', 'max:100'],
            'title.fr' => ['required', 'string', 'max:150'],
            'title.en' => ['nullable', 'string', 'max:150'],
            'startedAt' => ['nullable', 'date'],
            'endedAt' => ['nullable', 'date', 'after_or_equal:startedAt'],
            'ongoing' => ['boolean'],
            'dateLabel.*' => ['nullable', 'string', 'max:60'],
            'highlights.*' => ['nullable', 'string', 'max:1500'],
            'isCurrent' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return ['organization' => 'organisme', 'title.fr' => 'intitulé', 'startedAt' => 'date de début', 'endedAt' => 'date de fin'];
    }

    protected function resetFields(): void
    {
        $this->type = 'job';
        $this->organization = $this->location = $this->startedAt = $this->endedAt = '';
        $this->title = $this->dateLabel = $this->highlights = $this->emptyTranslation();
        $this->ongoing = $this->isCurrent = false;
    }

    protected function fillFields(Model $record): void
    {
        $this->type = $record->type->value;
        $this->organization = $record->organization;
        $this->location = (string) $record->location;
        $this->title = $this->translationsOf($record, 'title');
        $this->startedAt = (string) $record->started_at?->format('Y-m-d');
        $this->endedAt = (string) $record->ended_at?->format('Y-m-d');
        $this->ongoing = $record->started_at !== null && $record->ended_at === null;
        $this->dateLabel = $this->translationsOf($record, 'date_label');
        $this->highlights = $this->translationsOf($record, 'highlights');
        $this->isCurrent = $record->is_current;
    }

    protected function attributesToSave(): array
    {
        return [
            'type' => $this->type,
            'organization' => $this->organization,
            'location' => $this->location ?: null,
            'title' => $this->cleanTranslation($this->title),
            'started_at' => $this->startedAt ?: null,
            'ended_at' => $this->ongoing ? null : ($this->endedAt ?: null),
            'date_label' => $this->cleanTranslation($this->dateLabel),
            'highlights' => $this->cleanTranslation($this->highlights),
            'is_current' => $this->isCurrent,
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.experiences', ['items' => $this->items()]);
    }
}
