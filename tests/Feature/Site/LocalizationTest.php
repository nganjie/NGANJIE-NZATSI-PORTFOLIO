<?php

use App\Mail\NewContactMessage;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillDomain;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EnglishTranslationSeeder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake('public'));

test('the English home page shows English interface and content', function () {
    $this->seed(DatabaseSeeder::class);

    $this->get(route('en.home'))
        ->assertOk()
        ->assertSee('<html lang="en">', false)
        ->assertSee('that run')
        ->assertSee('See my projects')
        ->assertSee('From server to screen, end to end')
        ->assertSee('API &amp; back end', false)
        ->assertSee('Understand')
        ->assertSee('Full stack developer, C# .NET / Angular (work-study)')
        ->assertDontSee('Découvrir mes projets');
});

test('the French home page stays in French', function () {
    $this->seed(DatabaseSeeder::class);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<html lang="fr">', false)
        ->assertSee('Découvrir mes projets')
        ->assertSee('API et back-end')
        ->assertDontSee('See my projects');
});

test('the language switcher links to the same page in the other language', function () {
    $project = Project::factory()->create(['slug' => 'smartschools']);

    $this->get(route('projects.show', $project))
        ->assertSee('href="'.route('en.projects.show', $project).'"', false)
        ->assertSee('hreflang="en"', false);

    $this->get(route('en.projects.show', $project))
        ->assertOk()
        ->assertSee('href="'.route('projects.show', $project).'"', false)
        ->assertSee('<link rel="alternate" hreflang="fr" href="'.route('projects.show', $project).'">', false);
});

test('English project pages and the project list are available', function () {
    $project = Project::factory()->create([
        'title' => ['fr' => 'Plateforme scolaire', 'en' => 'School platform'],
        'summary' => ['fr' => 'Résumé français', 'en' => 'English summary'],
    ]);

    $this->get(route('en.projects.index'))
        ->assertOk()
        ->assertSee('All my projects')
        ->assertSee('School platform')
        ->assertSee(route('en.projects.show', $project));

    $this->get(route('en.projects.show', $project))
        ->assertSee('School platform')
        ->assertSee('English summary')
        ->assertDontSee('Résumé français');
});

test('missing English texts fall back to French', function () {
    Project::factory()->create(['title' => ['fr' => 'Projet seulement en français']]);

    $this->get(route('en.projects.index'))->assertSee('Projet seulement en français');
});

test('the English seeder never overwrites existing texts', function () {
    $this->seed(DatabaseSeeder::class);

    $domain = SkillDomain::query()->ordered()->first();
    $domain->setTranslation('title', 'en', 'My own title')->save();
    Profile::current()->setTranslation('bio', 'fr', 'Ma bio modifiée')->save();

    $this->seed(EnglishTranslationSeeder::class);

    expect($domain->fresh()->getTranslation('title', 'en'))->toBe('My own title')
        ->and(Profile::current()->getTranslation('bio', 'fr'))->toBe('Ma bio modifiée');
});

test('a message sent from the English page returns to the English page with English messages', function () {
    Mail::fake();
    RateLimiter::clear('contact:127.0.0.1');
    RateLimiter::clear('contact-day:127.0.0.1');

    $this->post(route('contact.store'), [
        'locale' => 'en',
        'type' => 'job',
        'name' => '',
        'email' => 'recruiter@example.com',
        'body' => 'Hello, we have an internship for you.',
        '_started' => encrypt(now()->subMinute()->timestamp),
    ])
        ->assertRedirect(route('en.home').'#contact')
        ->assertSessionHasErrors(['name' => 'The name field is required.']);

    $this->post(route('contact.store'), [
        'locale' => 'en',
        'type' => 'job',
        'name' => 'Recruiter',
        'email' => 'recruiter@example.com',
        'body' => 'Hello, we have an internship for you.',
        '_started' => encrypt(now()->subMinute()->timestamp),
    ])->assertRedirect(route('en.home').'#contact');

    Mail::assertQueued(NewContactMessage::class);
});

test('the sitemap lists both languages with alternates', function () {
    $project = Project::factory()->create();

    $this->get(route('sitemap'))
        ->assertOk()
        ->assertSee(route('en.home'))
        ->assertSee(route('en.projects.show', $project))
        ->assertSee('hreflang="en"', false);
});
