<?php

namespace App\Livewire\Admin\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Translatable form fields are stored as ['fr' => '…', 'en' => '…'] arrays.
 */
trait EditsTranslations
{
    public string $locale = 'fr';

    /**
     * @return array{fr: string, en: string}
     */
    protected function emptyTranslation(): array
    {
        return ['fr' => '', 'en' => ''];
    }

    /**
     * @return array{fr: string, en: string}
     */
    protected function translationsOf(Model $model, string $attribute): array
    {
        return [
            'fr' => (string) $model->getTranslation($attribute, 'fr', false),
            'en' => (string) $model->getTranslation($attribute, 'en', false),
        ];
    }

    /**
     * Drop empty locales so the French fallback applies.
     *
     * @param  array<string, string|null>  $values
     * @return array<string, string>
     */
    protected function cleanTranslation(array $values): array
    {
        $clean = array_filter(array_map(fn ($value) => is_string($value) ? trim($value) : $value, $values), fn ($value) => filled($value));

        return $clean;
    }
}
