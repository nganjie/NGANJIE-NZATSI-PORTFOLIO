<?php

namespace App\Models;

use App\Models\Concerns\HasPosition;
use App\Support\Lines;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['title', 'description', 'tags', 'position'])]
class SkillDomain extends Model
{
    use HasPosition, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['title', 'description', 'tags'];

    /**
     * @return list<string>
     */
    public function tagList(): array
    {
        return Lines::split($this->tags);
    }
}
