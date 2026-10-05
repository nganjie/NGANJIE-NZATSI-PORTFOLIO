<?php

use App\Models\Profile;
use App\Models\Project;
use App\Support\Settings;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake('public'));

test('the home page shows the profile and featured projects', function () {
    $this->seed(DatabaseSeeder::class);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Nganjie Nzatsi')
        ->assertSee('qui tournent')
        ->assertSee('SmartSchools')
        ->assertSee('ExbilCore')
        ->assertSee('SIGP SC Cameroun Sarl')
        ->assertSee('application/ld+json', false);
});

test('draft and non featured projects are not listed on the home page', function () {
    Project::factory()->featured()->create(['title' => ['fr' => 'Projet visible']]);
    Project::factory()->featured()->draft()->create(['title' => ['fr' => 'Projet brouillon']]);
    Project::factory()->create(['title' => ['fr' => 'Projet discret']]);

    $this->get(route('home'))
        ->assertSee('Projet visible')
        ->assertDontSee('Projet brouillon')
        ->assertDontSee('Projet discret');
});

test('the availability mention follows the profile setting', function () {
    $profile = Profile::current();
    $profile->update(['is_available' => true, 'availability_label' => ['fr' => 'Disponible dès janvier']]);

    $this->get(route('home'))->assertSee('Disponible dès janvier');

    $profile->update(['is_available' => false]);

    $this->get(route('home'))->assertDontSee('Disponible dès janvier');
});

test('a hidden section disappears from the page and the menu', function () {
    Settings::set('sections.visible', ['projects', 'skills', 'experience', 'technologies', 'contact']);

    $this->get(route('home'))
        ->assertDontSee('id="methode"', false)
        ->assertDontSee('#methode', false)
        ->assertSee('id="contact"', false);
});

test('the project list only shows published projects and can be filtered', function () {
    Project::factory()->professional()->create(['title' => ['fr' => 'Projet pro']]);
    Project::factory()->create(['title' => ['fr' => 'Projet perso']]);
    Project::factory()->draft()->create(['title' => ['fr' => 'Projet caché']]);

    $this->get(route('projects.index'))
        ->assertOk()
        ->assertSee('Projet pro')
        ->assertSee('Projet perso')
        ->assertDontSee('Projet caché');

    $this->get(route('projects.index', ['type' => 'personnel']))
        ->assertSee('Projet perso')
        ->assertDontSee('Projet pro');
});

test('a published project page shows its case study and records a view', function () {
    $project = Project::factory()->create();
    $project->tasks()->create(['position' => 1, 'title' => ['fr' => 'Étape importante'], 'body' => ['fr' => 'Détail']]);

    $this->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee($project->title)
        ->assertSee('Étape importante');

    expect($project->pageViews()->count())->toBe(1);
});

test('a draft project is hidden from guests but previewable by the admin', function () {
    $project = Project::factory()->draft()->create();

    $this->get(route('projects.show', $project))->assertNotFound();

    $this->actingAs(adminUser())
        ->get(route('projects.show', $project))
        ->assertOk()
        ->assertSee('Aperçu');
});

test('the sitemap lists published projects only', function () {
    $published = Project::factory()->create();
    $draft = Project::factory()->draft()->create();

    $this->get(route('sitemap'))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->assertSee(route('projects.show', $published))
        ->assertDontSee(route('projects.show', $draft));
});

test('the CV is downloadable once uploaded', function () {
    $this->get(route('cv.download'))->assertNotFound();

    $this->seed(DatabaseSeeder::class);

    $this->get(route('cv.download'))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
});

test('unknown pages show the custom 404 page', function () {
    $this->get('/projets/inexistant')
        ->assertNotFound()
        ->assertSee('Cette page')
        ->assertSee('noindex', false);
});
