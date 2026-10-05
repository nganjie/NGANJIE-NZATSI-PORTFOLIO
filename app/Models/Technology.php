<?php

namespace App\Models;

use App\Models\Concerns\HasPosition;
use Database\Factories\TechnologyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'category', 'show_on_home', 'position'])]
class Technology extends Model
{
    /** @use HasFactory<TechnologyFactory> */
    use HasFactory, HasPosition, HasTranslations;

    public const HOME_LIMIT = 8;

    /**
     * @var list<string>
     */
    public array $translatable = ['category'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['show_on_home' => 'boolean'];
    }

    /**
     * @return BelongsToMany<Project, $this>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withPivot('position');
    }
}
