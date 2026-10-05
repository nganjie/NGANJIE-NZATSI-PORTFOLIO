<?php

namespace App\Models;

use App\Enums\AccentColor;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Models\Concerns\HasPosition;
use App\Support\Lines;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

#[Fillable(['title', 'slug', 'summary', 'type', 'context', 'role', 'period', 'demo_url', 'repository_url', 'case_study', 'lesson', 'results', 'tags', 'accent_color', 'status', 'is_featured', 'position', 'seo_title', 'seo_description', 'published_at'])]
class Project extends Model implements HasMedia
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, HasPosition, HasTranslations, InteractsWithMedia;

    /**
     * @var list<string>
     */
    public array $translatable = [
        'title', 'summary', 'context', 'role', 'period', 'case_study',
        'lesson', 'results', 'tags', 'seo_title', 'seo_description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ProjectType::class,
            'status' => ProjectStatus::class,
            'accent_color' => AccentColor::class,
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (blank($project->slug)) {
                $project->slug = static::uniqueSlug($project->getTranslation('title', 'fr', false));
            }

            if ($project->status === ProjectStatus::Published && $project->published_at === null) {
                $project->published_at = now();
            }
        });

        static::deleting(fn (Project $project) => Profile::query()
            ->where('featured_project_id', $project->id)
            ->update(['featured_project_id' => null]));
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'projet';
        $slug = $base;
        $suffix = 2;

        while (static::query()->where('slug', $slug)->when($ignoreId, fn (Builder $q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasMany<ProjectTask, $this>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class)->orderBy('position')->orderBy('id');
    }

    /**
     * @return BelongsToMany<Technology, $this>
     */
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class)->withPivot('position')->orderByPivot('position');
    }

    /**
     * @return HasMany<PageView, $this>
     */
    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    /**
     * @param  Builder<Project>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('status', ProjectStatus::Published);
    }

    /**
     * @param  Builder<Project>  $query
     */
    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function isPublished(): bool
    {
        return $this->status === ProjectStatus::Published;
    }

    /**
     * Technology names joined for display ("C# .NET · Angular").
     */
    public function stackLabel(): string
    {
        return $this->technologies->pluck('name')->join(' · ');
    }

    /**
     * @return list<string>
     */
    public function resultLines(): array
    {
        return Lines::split($this->results);
    }

    /**
     * @return list<string>
     */
    public function tagList(): array
    {
        return Lines::split($this->tags);
    }

    public function nextPublished(): ?self
    {
        $published = static::query()->published()->ordered()->get(['id', 'slug', 'title', 'position']);
        $index = $published->search(fn (Project $p) => $p->id === $this->id);

        if ($published->count() < 2) {
            return null;
        }

        return $index === false ? $published->first() : $published->get(($index + 1) % $published->count());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Fit::Max, 400, 400)->format('webp')->quality(80);
        $this->addMediaConversion('md')->fit(Fit::Max, 800, 800)->format('webp')->quality(80);
        $this->addMediaConversion('lg')->fit(Fit::Max, 1600, 1600)->format('webp')->quality(80);
        $this->addMediaConversion('og')->fit(Fit::Crop, 1200, 630)->format('jpg')->quality(82)
            ->performOnCollections('cover');
    }
}
