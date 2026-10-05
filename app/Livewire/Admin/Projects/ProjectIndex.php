<?php

namespace App\Livewire\Admin\Projects;

use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Livewire\Admin\Concerns\ManagesOrderedList;
use App\Models\Project;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Projets')]
class ProjectIndex extends Component
{
    use ManagesOrderedList;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $type = '';

    #[Url(except: '')]
    public string $status = '';

    protected function orderedModel(): string
    {
        return Project::class;
    }

    public function toggleFeatured(int $id): void
    {
        $project = Project::query()->findOrFail($id);
        $project->update(['is_featured' => ! $project->is_featured]);

        $this->dispatch('notify', message: $project->is_featured ? 'Projet mis à la une.' : 'Projet retiré de la une.');
    }

    public function togglePublished(int $id): void
    {
        $project = Project::query()->findOrFail($id);
        $project->update(['status' => $project->isPublished() ? ProjectStatus::Draft : ProjectStatus::Published]);

        $this->dispatch('notify', message: $project->isPublished() ? 'Projet publié.' : 'Projet repassé en brouillon.');
    }

    public function delete(int $id): void
    {
        Project::query()->findOrFail($id)->delete();

        $this->dispatch('notify', message: 'Projet supprimé.');
    }

    public function isFiltered(): bool
    {
        return $this->search !== '' || $this->type !== '' || $this->status !== '';
    }

    public function render(): View
    {
        $projects = Project::query()
            ->with('media')
            ->when($this->search !== '', fn ($query) => $query->where(fn ($q) => $q
                ->whereRaw('LOWER(CAST(title AS TEXT)) LIKE ?', ['%'.mb_strtolower($this->search).'%'])
                ->orWhere('slug', 'like', '%'.mb_strtolower($this->search).'%')))
            ->when(ProjectType::tryFrom($this->type), fn ($query, $type) => $query->where('type', $type))
            ->when(ProjectStatus::tryFrom($this->status), fn ($query, $status) => $query->where('status', $status))
            ->ordered()
            ->get();

        return view('livewire.admin.projects.index', [
            'projects' => $projects,
            'total' => Project::query()->count(),
        ]);
    }
}
