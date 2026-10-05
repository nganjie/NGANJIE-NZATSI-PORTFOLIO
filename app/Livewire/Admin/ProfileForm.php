<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\EditsTranslations;
use App\Models\Profile;
use App\Models\Project;
use App\Support\MediaUploader;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Title('Profil et CV')]
class ProfileForm extends Component
{
    use EditsTranslations, WithFileUploads;

    public string $displayName = '';

    /** @var array{fr: string, en: string} */
    public array $headline = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $tagline = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $taglineHighlight = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $bio = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $availabilityLabel = ['fr' => '', 'en' => ''];

    public bool $isAvailable = false;

    public string $city = '';

    public string $email = '';

    public string $phone = '';

    public string $whatsapp = '';

    public string $githubUrl = '';

    public string $linkedinUrl = '';

    public ?int $featuredProjectId = null;

    /** @var TemporaryUploadedFile|null */
    public $photo = null;

    /** @var TemporaryUploadedFile|null */
    public $cv = null;

    public function mount(): void
    {
        $profile = Profile::current();

        $this->displayName = $profile->display_name;
        $this->headline = $this->translationsOf($profile, 'headline');
        $this->tagline = $this->translationsOf($profile, 'tagline');
        $this->taglineHighlight = $this->translationsOf($profile, 'tagline_highlight');
        $this->bio = $this->translationsOf($profile, 'bio');
        $this->availabilityLabel = $this->translationsOf($profile, 'availability_label');
        $this->isAvailable = $profile->is_available;
        $this->city = (string) $profile->city;
        $this->email = $profile->email;
        $this->phone = (string) $profile->phone;
        $this->whatsapp = (string) $profile->whatsapp;
        $this->githubUrl = (string) $profile->github_url;
        $this->linkedinUrl = (string) $profile->linkedin_url;
        $this->featuredProjectId = $profile->featured_project_id;
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'displayName' => ['required', 'string', 'max:100'],
            'headline.fr' => ['required', 'string', 'max:150'],
            'headline.en' => ['nullable', 'string', 'max:150'],
            'tagline.fr' => ['required', 'string', 'max:120'],
            'tagline.en' => ['nullable', 'string', 'max:120'],
            'taglineHighlight.*' => ['nullable', 'string', 'max:60'],
            'bio.fr' => ['required', 'string', 'max:600'],
            'bio.en' => ['nullable', 'string', 'max:600'],
            'availabilityLabel.*' => ['nullable', 'string', 'max:120'],
            'isAvailable' => ['boolean'],
            'city' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30', 'regex:/^\+?[0-9 ]{8,20}$/'],
            'githubUrl' => ['nullable', 'url', 'max:255'],
            'linkedinUrl' => ['nullable', 'url', 'max:255'],
            'featuredProjectId' => ['nullable', 'exists:projects,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'displayName' => 'nom affiché', 'headline.fr' => 'titre', 'tagline.fr' => "titre d'accueil",
            'bio.fr' => 'présentation', 'email' => 'e-mail', 'whatsapp' => 'WhatsApp',
            'githubUrl' => 'lien GitHub', 'linkedinUrl' => 'lien LinkedIn', 'photo' => 'photo', 'cv' => 'CV',
        ];
    }

    public function toggleAvailability(): void
    {
        $this->isAvailable = ! $this->isAvailable;
    }

    public function save(): void
    {
        $this->validate();

        $profile = Profile::current();

        $profile->fill([
            'display_name' => $this->displayName,
            'headline' => $this->cleanTranslation($this->headline),
            'tagline' => $this->cleanTranslation($this->tagline),
            'tagline_highlight' => $this->cleanTranslation($this->taglineHighlight),
            'bio' => $this->cleanTranslation($this->bio),
            'availability_label' => $this->cleanTranslation($this->availabilityLabel),
            'is_available' => $this->isAvailable,
            'city' => $this->city ?: null,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'whatsapp' => $this->whatsapp ?: null,
            'github_url' => $this->githubUrl ?: null,
            'linkedin_url' => $this->linkedinUrl ?: null,
            'featured_project_id' => $this->featuredProjectId ?: null,
        ]);

        if ($this->photo) {
            MediaUploader::attach($profile, $this->photo, 'photo', ['alt' => ['fr' => 'Photo de '.$this->displayName]]);
        }

        if ($this->cv) {
            MediaUploader::attach($profile, $this->cv, 'cv');
            $profile->cv_updated_at = now();
        }

        $profile->save();

        $this->reset('photo', 'cv');
        $this->dispatch('notify', message: 'Profil enregistré.');
    }

    public function removePhoto(): void
    {
        Profile::current()->clearMediaCollection('photo');
        Profile::current()->touch();
        $this->dispatch('notify', message: 'Photo supprimée.');
    }

    public function render(): View
    {
        $profile = Profile::current()->load('media');

        return view('livewire.admin.profile-form', [
            'profile' => $profile,
            'currentPhoto' => $profile->getFirstMedia('photo'),
            'currentCv' => $profile->getFirstMedia('cv'),
            'projects' => Project::query()->published()->ordered()->get(['id', 'title']),
        ]);
    }
}
