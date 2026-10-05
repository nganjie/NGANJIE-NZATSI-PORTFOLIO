<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * Single-row table holding the site owner's public profile.
 */
#[Fillable(['display_name', 'headline', 'tagline', 'tagline_highlight', 'bio', 'city', 'is_available', 'availability_label', 'email', 'phone', 'whatsapp', 'github_url', 'linkedin_url', 'cv_updated_at', 'featured_project_id'])]
class Profile extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    /**
     * @var list<string>
     */
    public array $translatable = ['headline', 'tagline', 'tagline_highlight', 'bio', 'availability_label'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'cv_updated_at' => 'date',
        ];
    }

    public static function current(): self
    {
        return static::query()->oldest('id')->firstOrCreate([], [
            'display_name' => config('app.name'),
            'headline' => ['fr' => 'Développeur'],
            'tagline' => ['fr' => config('app.name')],
            'bio' => ['fr' => ''],
            'is_available' => false,
            'email' => config('mail.from.address'),
        ]);
    }

    /**
     * @return BelongsTo<Project, $this>
     */
    public function featuredProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'featured_project_id');
    }

    public function whatsappUrl(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->whatsapp);

        return $digits ? 'https://wa.me/'.$digits : null;
    }

    public function hasCv(): bool
    {
        return $this->getFirstMedia('cv') !== null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('cv')->singleFile()
            ->acceptsMimeTypes(['application/pdf']);

        $this->addMediaCollection('share_image')->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('sm')->fit(Fit::Crop, 300, 300)->format('webp')->quality(82)
            ->performOnCollections('photo');
        $this->addMediaConversion('md')->fit(Fit::Crop, 600, 600)->format('webp')->quality(82)
            ->performOnCollections('photo');
        $this->addMediaConversion('og')->fit(Fit::Crop, 1200, 630)->format('jpg')->quality(82)
            ->performOnCollections('share_image');
    }
}
