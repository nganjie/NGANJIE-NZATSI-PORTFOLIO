<?php

namespace App\Livewire\Admin\Projects;

use App\Enums\AccentColor;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Livewire\Admin\Concerns\EditsTranslations;
use App\Models\Project;
use App\Models\Technology;
use App\Support\MediaUploader;
use App\Support\RichText;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectForm extends Component
{
    use EditsTranslations, WithFileUploads;

    public ?Project $project = null;

    /** @var array{fr: string, en: string} */
    public array $title = ['fr' => '', 'en' => ''];

    public string $slug = '';

    public bool $slugTouched = false;

    /** @var array{fr: string, en: string} */
    public array $summary = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $role = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $context = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $period = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $tags = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $caseStudy = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $lesson = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $results = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $seoTitle = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $seoDescription = ['fr' => '', 'en' => ''];

    public string $demoUrl = '';

    public string $repositoryUrl = '';

    public string $type = 'professional';

    public string $status = 'draft';

    public bool $isFeatured = false;

    public string $accentColor = 'violet';

    /** @var list<int> */
    public array $technologyIds = [];

    /** @var list<array{id: int|null, title: array{fr: string, en: string}, body: array{fr: string, en: string}}> */
    public array $tasks = [];

    /** @var TemporaryUploadedFile|null */
    public $cover = null;

    /** @var array<int, TemporaryUploadedFile> */
    public array $galleryUploads = [];

    /** @var array<int|string, array{alt: string, caption: string}> */
    public array $galleryMeta = [];

    public function mount(?Project $project = null): void
    {
        if ($project === null || ! $project->exists) {
            $this->project = null;
            $this->tasks = [];

            return;
        }

        $this->project = $project;
        $this->slug = $project->slug;
        $this->slugTouched = true;

        foreach (['title', 'summary', 'role', 'context', 'period', 'tags', 'lesson', 'results'] as $attribute) {
            $this->{$attribute} = $this->translationsOf($project, $attribute);
        }

        $this->caseStudy = $this->translationsOf($project, 'case_study');
        $this->seoTitle = $this->translationsOf($project, 'seo_title');
        $this->seoDescription = $this->translationsOf($project, 'seo_description');
        $this->demoUrl = (string) $project->demo_url;
        $this->repositoryUrl = (string) $project->repository_url;
        $this->type = $project->type->value;
        $this->status = $project->status->value;
        $this->isFeatured = $project->is_featured;
        $this->accentColor = $project->accent_color->value;
        $this->technologyIds = $project->technologies()->pluck('technologies.id')->map(fn ($id) => (int) $id)->all();
        $this->tasks = $project->tasks()->get()->map(fn ($task) => [
            'id' => $task->id,
            'title' => $this->translationsOf($task, 'title'),
            'body' => $this->translationsOf($task, 'body'),
        ])->all();

        foreach ($project->getMedia('gallery') as $media) {
            $this->galleryMeta[$media->id] = [
                'alt' => (string) $media->getCustomProperty('alt.fr', ''),
                'caption' => (string) $media->getCustomProperty('caption.fr', ''),
            ];
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->slugTouched) {
            $this->slug = Str::slug($this->title['fr']);
        }
    }

    public function updatedSlug(): void
    {
        $this->slugTouched = true;
        $this->slug = Str::slug($this->slug);
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title.fr' => ['required', 'string', 'max:120'],
            'title.en' => ['nullable', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120', 'alpha_dash', Rule::unique('projects', 'slug')->ignore($this->project?->id)],
            'summary.fr' => ['required', 'string', 'max:300'],
            'summary.en' => ['nullable', 'string', 'max:300'],
            'role.*' => ['nullable', 'string', 'max:200'],
            'context.*' => ['nullable', 'string', 'max:200'],
            'period.*' => ['nullable', 'string', 'max:60'],
            'tags.*' => ['nullable', 'string', 'max:300'],
            'caseStudy.*' => ['nullable', 'string', 'max:60000'],
            'lesson.*' => ['nullable', 'string', 'max:400'],
            'results.*' => ['nullable', 'string', 'max:2000'],
            'seoTitle.*' => ['nullable', 'string', 'max:70'],
            'seoDescription.*' => ['nullable', 'string', 'max:170'],
            'demoUrl' => ['nullable', 'url', 'max:255'],
            'repositoryUrl' => ['nullable', 'url', 'max:255'],
            'type' => ['required', Rule::enum(ProjectType::class)],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'isFeatured' => ['boolean'],
            'accentColor' => ['required', Rule::enum(AccentColor::class)],
            'technologyIds' => ['array'],
            'technologyIds.*' => ['integer', 'exists:technologies,id'],
            'tasks' => ['array', 'max:20'],
            'tasks.*.title.fr' => ['required', 'string', 'max:150'],
            'tasks.*.title.en' => ['nullable', 'string', 'max:150'],
            'tasks.*.body.*' => ['nullable', 'string', 'max:600'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'galleryUploads' => ['array', 'max:12'],
            'galleryUploads.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'galleryMeta.*.alt' => ['nullable', 'string', 'max:200'],
            'galleryMeta.*.caption' => ['nullable', 'string', 'max:200'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'title.fr' => 'titre', 'slug' => 'adresse de la page', 'summary.fr' => 'résumé',
            'demoUrl' => 'lien du site', 'repositoryUrl' => 'lien du dépôt', 'tasks.*.title.fr' => 'titre de l\'étape',
            'cover' => 'image de couverture', 'galleryUploads.*' => 'image', 'seoTitle.*' => 'titre SEO', 'seoDescription.*' => 'description SEO',
        ];
    }

    public function addTask(): void
    {
        $this->tasks[] = ['id' => null, 'title' => $this->emptyTranslation(), 'body' => $this->emptyTranslation()];
    }

    public function removeTask(int $index): void
    {
        unset($this->tasks[$index]);
        $this->tasks = array_values($this->tasks);
    }

    public function moveTask(int $index, int $offset): void
    {
        $target = $index + $offset;

        if (! isset($this->tasks[$index], $this->tasks[$target])) {
            return;
        }

        [$this->tasks[$index], $this->tasks[$target]] = [$this->tasks[$target], $this->tasks[$index]];
    }

    public function sortTask(int|string $item, int $position): void
    {
        $task = $this->tasks[(int) $item] ?? null;

        if ($task === null) {
            return;
        }

        unset($this->tasks[(int) $item]);
        $tasks = array_values($this->tasks);
        array_splice($tasks, max(0, $position), 0, [$task]);
        $this->tasks = $tasks;
    }

    public function toggleTechnology(int $id): void
    {
        $this->technologyIds = in_array($id, $this->technologyIds, true)
            ? array_values(array_diff($this->technologyIds, [$id]))
            : [...$this->technologyIds, $id];
    }

    public function toggleFeatured(): void
    {
        $this->isFeatured = ! $this->isFeatured;
    }

    public function removeGalleryUpload(int $index): void
    {
        unset($this->galleryUploads[$index]);
        $this->galleryUploads = array_values($this->galleryUploads);
    }

    public function deleteMedia(int $mediaId): void
    {
        $media = $this->project?->media()->whereKey($mediaId)->first();

        if ($media instanceof Media) {
            $media->delete();
            unset($this->galleryMeta[$mediaId]);
            $this->project->touch();
            $this->dispatch('notify', message: 'Image supprimée.');
        }
    }

    public function sortGallery(int|string $item, int $position): void
    {
        if ($this->project === null) {
            return;
        }

        $galleryIds = $this->project->getMedia('gallery')->pluck('id');

        if (! $galleryIds->contains((int) $item)) {
            return;
        }

        $ids = $galleryIds->reject(fn ($id) => (string) $id === (string) $item)->values()->all();
        array_splice($ids, max(0, $position), 0, [(int) $item]);
        Media::setNewOrder($ids);
        $this->project->touch();
    }

    public function save(): void
    {
        $this->validate();

        $previousSlug = $this->project?->slug;

        $project = DB::transaction(function () {
            $project = $this->project ?? new Project;

            $project->fill([
                'title' => $this->cleanTranslation($this->title),
                'slug' => $this->slug,
                'summary' => $this->cleanTranslation($this->summary),
                'role' => $this->cleanTranslation($this->role),
                'context' => $this->cleanTranslation($this->context),
                'period' => $this->cleanTranslation($this->period),
                'tags' => $this->cleanTranslation($this->tags),
                'case_study' => array_filter(array_map(fn ($html) => RichText::sanitize($html), $this->caseStudy)),
                'lesson' => $this->cleanTranslation($this->lesson),
                'results' => $this->cleanTranslation($this->results),
                'seo_title' => $this->cleanTranslation($this->seoTitle),
                'seo_description' => $this->cleanTranslation($this->seoDescription),
                'demo_url' => $this->demoUrl ?: null,
                'repository_url' => $this->repositoryUrl ?: null,
                'type' => $this->type,
                'status' => $this->status,
                'is_featured' => $this->isFeatured,
                'accent_color' => $this->accentColor,
            ]);
            $project->save();

            $project->technologies()->sync(collect($this->technologyIds)->values()->mapWithKeys(fn ($id, $index) => [$id => ['position' => $index + 1]])->all());

            $keptTaskIds = [];

            foreach (array_values($this->tasks) as $index => $task) {
                $model = $task['id'] ? $project->tasks()->find($task['id']) : null;
                $model ??= $project->tasks()->make();
                $model->fill([
                    'position' => $index + 1,
                    'title' => $this->cleanTranslation($task['title']),
                    'body' => $this->cleanTranslation($task['body']),
                ])->save();
                $keptTaskIds[] = $model->id;
            }

            $project->tasks()->whereNotIn('id', $keptTaskIds)->delete();

            return $project;
        });

        if ($this->cover) {
            MediaUploader::attach($project, $this->cover, 'cover', ['alt' => ['fr' => 'Capture d\'écran de '.$this->title['fr']]]);
        }

        foreach ($this->galleryUploads as $upload) {
            $media = MediaUploader::attach($project, $upload, 'gallery', ['alt' => ['fr' => $this->title['fr']]]);
            $this->galleryMeta[$media->id] = ['alt' => $this->title['fr'], 'caption' => ''];
        }

        foreach ($project->getMedia('gallery') as $media) {
            if (isset($this->galleryMeta[$media->id])) {
                $media->setCustomProperty('alt.fr', $this->galleryMeta[$media->id]['alt'] ?: $this->title['fr']);
                $media->setCustomProperty('caption.fr', $this->galleryMeta[$media->id]['caption']);
                $media->save();
            }
        }

        $wasCreating = $this->project === null;
        $this->reset('cover', 'galleryUploads');

        if ($wasCreating || $previousSlug !== $project->slug) {
            session()->flash('status', $wasCreating ? 'Projet créé.' : 'Projet enregistré.');
            $this->redirectRoute('admin.projects.edit', ['project' => $project], navigate: true);

            return;
        }

        $this->project = $project->fresh();
        $this->tasks = $this->project->tasks()->get()->map(fn ($task) => [
            'id' => $task->id,
            'title' => $this->translationsOf($task, 'title'),
            'body' => $this->translationsOf($task, 'body'),
        ])->all();

        $this->dispatch('notify', message: 'Projet enregistré.');
    }

    public function delete(): void
    {
        $this->project?->delete();

        session()->flash('status', 'Projet supprimé.');
        $this->redirectRoute('admin.projects.index', navigate: true);
    }

    public function render(): View
    {
        $this->project?->loadMissing('media');

        return view('livewire.admin.projects.form', [
            'technologies' => Technology::query()->ordered()->get(),
            'currentCover' => $this->project?->getFirstMedia('cover'),
            'gallery' => $this->project?->getMedia('gallery') ?? collect(),
        ])->title($this->project ? 'Modifier '.$this->project->title : 'Nouveau projet');
    }
}
