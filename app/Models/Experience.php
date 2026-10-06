<?php

namespace App\Models;

use App\Enums\ExperienceType;
use App\Models\Concerns\HasPosition;
use App\Support\Lines;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['type', 'organization', 'location', 'title', 'started_at', 'ended_at', 'date_label', 'highlights', 'is_current', 'position'])]
class Experience extends Model
{
    use HasPosition, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['title', 'date_label', 'highlights'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ExperienceType::class,
            'started_at' => 'date',
            'ended_at' => 'date',
            'is_current' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (Experience $experience) {
            if ($experience->is_current) {
                static::query()->whereKeyNot($experience->id)->where('is_current', true)->update(['is_current' => false]);
            }
        });
    }

    /**
     * Human readable period, e.g. "Févr. 2024 → aujourd'hui".
     */
    public function periodLabel(): string
    {
        if (filled($this->date_label)) {
            return $this->date_label;
        }

        $format = fn ($date) => ucfirst($date->locale(app()->getLocale())->translatedFormat('M Y'));

        if ($this->started_at === null) {
            return $this->ended_at ? $format($this->ended_at) : '';
        }

        $end = $this->ended_at ? $format($this->ended_at) : __("aujourd'hui");

        return $format($this->started_at).' → '.$end;
    }

    /**
     * @return list<string>
     */
    public function highlightList(): array
    {
        return Lines::split($this->highlights);
    }
}
