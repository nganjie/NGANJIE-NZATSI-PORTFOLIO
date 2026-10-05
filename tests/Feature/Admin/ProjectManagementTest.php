<?php

use App\Enums\ProjectStatus;
use App\Livewire\Admin\Projects\ProjectForm;
use App\Livewire\Admin\Projects\ProjectIndex;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(adminUser());
});

test('a project can be created with tasks and technologies', function () {
    $dotnet = Technology::factory()->create(['name' => 'C# .NET']);
    $angular = Technology::factory()->create(['name' => 'Angular']);

    Livewire::test(ProjectForm::class)
        ->set('title.fr', 'Nouvelle plateforme')
        ->assertSet('slug', 'nouvelle-plateforme')
        ->set('summary.fr', 'Une plateforme de test.')
        ->set('status', 'published')
        ->call('toggleTechnology', $angular->id)
        ->call('toggleTechnology', $dotnet->id)
        ->call('addTask')
        ->set('tasks.0.title.fr', 'Conception de l\'API')
        ->set('caseStudy.fr', '<div>Texte <strong>riche</strong></div>')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.projects.edit', 'nouvelle-plateforme'));

    $project = Project::query()->where('slug', 'nouvelle-plateforme')->sole();

    expect($project->status)->toBe(ProjectStatus::Published)
        ->and($project->published_at)->not->toBeNull()
        ->and($project->technologies->pluck('name')->all())->toBe(['Angular', 'C# .NET'])
        ->and($project->tasks->first()->title)->toBe('Conception de l\'API')
        ->and($project->case_study)->toBe('<div>Texte <strong>riche</strong></div>');
});

test('the French title and summary are required and the slug must be unique', function () {
    Project::factory()->create(['slug' => 'deja-pris']);

    Livewire::test(ProjectForm::class)
        ->set('slug', 'deja-pris')
        ->call('save')
        ->assertHasErrors(['title.fr', 'summary.fr', 'slug']);
});

test('dangerous HTML is removed from the case study', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectForm::class, ['project' => $project])
        ->set('caseStudy.fr', '<p onclick="alert(1)">Bonjour</p><script>alert(1)</script><a href="javascript:alert(1)">lien</a>')
        ->call('save')
        ->assertHasNoErrors();

    $html = $project->fresh()->case_study;

    expect($html)->toContain('Bonjour')
        ->not->toContain('<script')
        ->not->toContain('onclick')
        ->not->toContain('javascript:');
});

test('the English version is optional and falls back to French', function () {
    $project = Project::factory()->create(['title' => ['fr' => 'Titre français']]);

    Livewire::test(ProjectForm::class, ['project' => $project])
        ->set('locale', 'en')
        ->set('title.en', 'English title')
        ->call('save')
        ->assertHasNoErrors();

    $project->refresh();

    expect($project->getTranslation('title', 'en'))->toBe('English title')
        ->and($project->getTranslation('summary', 'en'))->toBe($project->getTranslation('summary', 'fr'));
});

test('a cover image and gallery images can be uploaded', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectForm::class, ['project' => $project])
        ->set('cover', UploadedFile::fake()->image('cover.jpg', 1600, 900))
        ->set('galleryUploads', [UploadedFile::fake()->image('ecran.png', 1200, 800)])
        ->call('save')
        ->assertHasNoErrors();

    expect($project->fresh()->getFirstMedia('cover')->getCustomProperty('width'))->toBe(1600)
        ->and($project->fresh()->getMedia('gallery'))->toHaveCount(1);
});

test('a non image file is rejected as cover', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectForm::class, ['project' => $project])
        ->set('cover', UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'))
        ->call('save')
        ->assertHasErrors('cover');
});

test('projects can be featured, published and reordered from the list', function () {
    [$first, $second, $third] = Project::factory()->count(3)->create();

    Livewire::test(ProjectIndex::class)
        ->call('toggleFeatured', $first->id)
        ->call('togglePublished', $second->id)
        ->call('sortItem', $third->id, 0);

    expect($first->fresh()->is_featured)->toBeTrue()
        ->and($second->fresh()->status)->toBe(ProjectStatus::Draft)
        ->and(Project::query()->ordered()->pluck('id')->all())->toBe([$third->id, $first->id, $second->id]);
});

test('the list can be searched and filtered', function () {
    Project::factory()->create(['title' => ['fr' => 'Plateforme bancaire'], 'slug' => 'plateforme-bancaire']);
    Project::factory()->draft()->create(['title' => ['fr' => 'Outil interne'], 'slug' => 'outil-interne']);

    Livewire::test(ProjectIndex::class)
        ->set('search', 'bancaire')
        ->assertSee('Plateforme bancaire')
        ->assertDontSee('Outil interne')
        ->set('search', '')
        ->set('status', 'draft')
        ->assertSee('Outil interne')
        ->assertDontSee('Plateforme bancaire');
});

test('a project can be deleted', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectIndex::class)->call('delete', $project->id);

    expect(Project::query()->count())->toBe(0);
});
