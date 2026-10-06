<?php

namespace App\Livewire\Admin;

use App\Livewire\Admin\Concerns\EditsTranslations;
use App\Models\Profile;
use App\Support\MediaUploader;
use App\Support\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Title('Paramètres')]
class SettingsForm extends Component
{
    use EditsTranslations, WithFileUploads;

    /** @var array{fr: string, en: string} */
    public array $seoTitle = ['fr' => '', 'en' => ''];

    /** @var array{fr: string, en: string} */
    public array $seoDescription = ['fr' => '', 'en' => ''];

    /** @var list<string> */
    public array $sections = [];

    public string $notifyEmail = '';

    /** @var TemporaryUploadedFile|null */
    public $shareImage = null;

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPassword_confirmation = '';

    public function mount(): void
    {
        $this->seoTitle = $this->settingTranslations('seo.default_title');
        $this->seoDescription = $this->settingTranslations('seo.default_description');
        $this->sections = array_values((array) Settings::get('sections.visible'));
        $this->notifyEmail = (string) Settings::get('contact.notify_email');
    }

    /**
     * @return array{fr: string, en: string}
     */
    private function settingTranslations(string $key): array
    {
        $value = Settings::get($key);
        $value = is_array($value) ? $value : ['fr' => (string) $value];

        return ['fr' => (string) ($value['fr'] ?? ''), 'en' => (string) ($value['en'] ?? '')];
    }

    public function toggleSection(string $section): void
    {
        $this->sections = in_array($section, $this->sections, true)
            ? array_values(array_diff($this->sections, [$section]))
            : [...$this->sections, $section];
    }

    public function save(): void
    {
        $this->validate([
            'seoTitle.fr' => ['required', 'string', 'max:70'],
            'seoTitle.en' => ['nullable', 'string', 'max:70'],
            'seoDescription.*' => ['nullable', 'string', 'max:170'],
            'sections' => ['array'],
            'sections.*' => [Rule::in(array_keys(Settings::SECTIONS))],
            'notifyEmail' => ['nullable', 'email', 'max:255'],
            'shareImage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ], attributes: ['seoTitle.fr' => 'titre par défaut', 'notifyEmail' => 'e-mail de notification', 'shareImage' => 'image de partage']);

        Settings::set('seo.default_title', $this->cleanTranslation($this->seoTitle));
        Settings::set('seo.default_description', $this->cleanTranslation($this->seoDescription));
        Settings::set('sections.visible', array_values(array_intersect(array_keys(Settings::SECTIONS), $this->sections)));
        Settings::set('contact.notify_email', $this->notifyEmail ?: null);

        if ($this->shareImage) {
            $profile = Profile::current();
            MediaUploader::attach($profile, $this->shareImage, 'share_image');
            $profile->touch();
            $this->reset('shareImage');
        }

        $this->dispatch('notify', message: 'Paramètres enregistrés.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'currentPassword' => ['required', 'current_password'],
            'newPassword' => ['required', 'confirmed', Password::defaults()],
        ], attributes: ['currentPassword' => 'mot de passe actuel', 'newPassword' => 'nouveau mot de passe']);

        Auth::user()->update(['password' => $this->newPassword]);

        $this->reset('currentPassword', 'newPassword', 'newPassword_confirmation');
        $this->dispatch('notify', message: 'Mot de passe modifié.');
    }

    public function render(): View
    {
        return view('livewire.admin.settings-form', [
            'currentShareImage' => Profile::current()->load('media')->getFirstMedia('share_image'),
        ]);
    }
}
