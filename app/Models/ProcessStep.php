<?php

namespace App\Models;

use App\Models\Concerns\HasPosition;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['position', 'title', 'body'])]
class ProcessStep extends Model
{
    use HasPosition, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['title', 'body'];
}
