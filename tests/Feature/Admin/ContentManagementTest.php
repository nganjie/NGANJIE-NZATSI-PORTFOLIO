<?php

use App\Livewire\Admin\Experiences;
use App\Livewire\Admin\Messages;
use App\Livewire\Admin\ProfileForm;
use App\Livewire\Admin\SettingsForm;
use App\Livewire\Admin\Skills;
use App\Livewire\Admin\Technologies;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\SkillDomain;
use App\Models\Technology;
use App\Support\Settings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(adminUser());
});

test('skill domains can be created, edited, reordered and deleted', function () {
    Livewire::test(Skills::class)
        ->call('create')
        ->set('title.fr', 'Back-end')
        ->set('description.fr', 'Des API solides.')
        ->set('tags.fr', "C#\nLaravel")
        ->call('save')
        ->assertHasNoErrors()
        ->call('create')
        ->set('title.fr', 'Front-end')
        ->set('description.fr', 'Des interfaces claires.')
        ->set('tags.fr', 'Angular')
        ->call('save');

    [$backend, $frontend] = SkillDomain::query()->ordered()->get();

    expect($backend->tagList())->toBe(['C#', 'Laravel']);

    Livewire::test(Skills::class)
        ->call('moveDown', $backend->id)
        ->call('edit', $frontend->id)
        ->set('title.fr', 'Interfaces web')
        ->call('save')
        ->call('delete', $backend->id);

    expect(SkillDomain::query()->ordered()->pluck('title')->all())->toBe(['Interfaces web']);
});

test('technology names must be unique', function () {
    Technology::factory()->create(['name' => 'Laravel']);

    Livewire::test(Technologies::class)
        ->call('create')
        ->set('name', 'Laravel')
        ->set('category.fr', 'Back-end')
        ->call('save')
        ->assertHasErrors('name');
});

test('only one experience can be the current position', function () {
    $old = Experience::query()->create(['type' => 'job', 'organization' => 'Ancienne', 'title' => ['fr' => 'Poste'], 'is_current' => true]);

    Livewire::test(Experiences::class)
        ->call('create')
        ->set('organization', 'Nouvelle entreprise')
        ->set('title.fr', 'Développeur')
        ->set('startedAt', '2026-01-01')
        ->set('ongoing', true)
        ->set('isCurrent', true)
        ->call('save')
        ->assertHasNoErrors();

    expect($old->fresh()->is_current)->toBeFalse()
        ->and(Experience::query()->where('is_current', true)->sole()->organization)->toBe('Nouvelle entreprise');
});

test('the profile can be updated and a PDF CV uploaded', function () {
    Livewire::test(ProfileForm::class)
        ->set('displayName', 'Nganjie Nzatsi')
        ->set('headline.fr', 'Développeur full stack')
        ->set('tagline.fr', 'Je construis')
        ->set('bio.fr', 'Présentation courte.')
        ->set('email', 'contact@example.com')
        ->call('toggleAvailability')
        ->set('cv', UploadedFile::fake()->createWithContent('cv.pdf', file_get_contents(database_path('seeders/files/cv-nganjie-nzatsi.pdf'))))
        ->call('save')
        ->assertHasNoErrors();

    $profile = Profile::current();

    expect($profile->email)->toBe('contact@example.com')
        ->and($profile->hasCv())->toBeTrue()
        ->and($profile->cv_updated_at->isToday())->toBeTrue();
});

test('a CV that is not a PDF is rejected', function () {
    Livewire::test(ProfileForm::class)
        ->set('cv', UploadedFile::fake()->image('cv.png'))
        ->call('save')
        ->assertHasErrors('cv');
});

test('opening a message marks it as read and it can be archived', function () {
    $message = Message::factory()->create();

    Livewire::test(Messages::class)
        ->call('open', $message->id)
        ->assertSee($message->body);

    expect($message->fresh()->isRead())->toBeTrue();

    Livewire::test(Messages::class)->call('toggleArchive', $message->id);

    expect($message->fresh()->archived_at)->not->toBeNull();

    Livewire::test(Messages::class)->call('delete', $message->id);

    expect(Message::query()->count())->toBe(0)
        ->and(Message::onlyTrashed()->count())->toBe(1);
});

test('settings can hide home sections', function () {
    Livewire::test(SettingsForm::class)
        ->call('toggleSection', 'process')
        ->call('save')
        ->assertHasNoErrors();

    expect(Settings::sectionVisible('process'))->toBeFalse()
        ->and(Settings::sectionVisible('projects'))->toBeTrue();
});

test('the admin password can be changed', function () {
    Livewire::test(SettingsForm::class)
        ->set('currentPassword', 'password')
        ->set('newPassword', 'nouveau-mot-de-passe-1')
        ->set('newPassword_confirmation', 'nouveau-mot-de-passe-1')
        ->call('updatePassword')
        ->assertHasNoErrors();

    expect(Hash::check('nouveau-mot-de-passe-1', auth()->user()->fresh()->password))->toBeTrue();
});
