<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Key/value site settings, cached as a whole.
 */
class Settings
{
    private const CACHE_KEY = 'settings.all';

    /**
     * Default values used when a setting has never been saved.
     *
     * @var array<string, mixed>
     */
    public const DEFAULTS = [
        'seo.default_title' => 'Nganjie Nzatsi — Développeur full stack à Douala',
        'seo.default_description' => '',
        'sections.visible' => ['projects', 'skills', 'experience', 'technologies', 'process', 'contact'],
        'contact.notify_email' => null,
    ];

    /**
     * Home page sections that can be hidden, with their menu label.
     *
     * @var array<string, string>
     */
    public const SECTIONS = [
        'projects' => 'Projets',
        'skills' => 'Compétences',
        'experience' => 'Parcours',
        'technologies' => 'Technologies',
        'process' => 'Méthode',
        'contact' => 'Contact',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = Cache::rememberForever(self::CACHE_KEY, fn () => Setting::query()->pluck('value', 'key')->all());

        return $all[$key] ?? $default ?? self::DEFAULTS[$key] ?? null;
    }

    public static function set(string $key, mixed $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(self::CACHE_KEY);
    }

    public static function sectionVisible(string $section): bool
    {
        return in_array($section, (array) self::get('sections.visible'), true);
    }
}
