<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

/**
 * Locales of the public site. French lives at the root of the site,
 * every other locale under its own prefix (/en/...), with route names
 * prefixed the same way ("en.home", "en.projects.show"...).
 */
class Localization
{
    public const DEFAULT = 'fr';

    /**
     * @var array<string, array{name: string, native: string, og: string}>
     */
    public const LOCALES = [
        'fr' => ['name' => 'Français', 'native' => 'FR', 'og' => 'fr_FR'],
        'en' => ['name' => 'English', 'native' => 'EN', 'og' => 'en_US'],
    ];

    /**
     * @return list<string>
     */
    public static function codes(): array
    {
        return array_keys(self::LOCALES);
    }

    public static function isSupported(?string $locale): bool
    {
        return $locale !== null && array_key_exists($locale, self::LOCALES);
    }

    public static function current(): string
    {
        $locale = app()->getLocale();

        return self::isSupported($locale) ? $locale : self::DEFAULT;
    }

    /**
     * Route name for a locale: "home" in French, "en.home" in English.
     */
    public static function routeName(string $name, ?string $locale = null): string
    {
        $locale ??= self::current();
        $base = self::baseName($name);

        return $locale === self::DEFAULT ? $base : $locale.'.'.$base;
    }

    /**
     * Route name without its locale prefix.
     */
    public static function baseName(string $name): string
    {
        foreach (self::codes() as $code) {
            if ($code !== self::DEFAULT && str_starts_with($name, $code.'.')) {
                return substr($name, strlen($code) + 1);
            }
        }

        return $name;
    }

    /**
     * @param  mixed  $parameters
     */
    public static function route(string $name, $parameters = [], ?string $locale = null): string
    {
        return route(self::routeName($name, $locale), $parameters);
    }

    /**
     * URL of the current page in another locale (home page as a fallback).
     */
    public static function switchUrl(string $locale): string
    {
        $route = Route::current();
        $name = $route?->getName();

        if ($name === null || ! Route::has(self::routeName($name, $locale))) {
            return self::route('home', [], $locale);
        }

        $url = self::route($name, $route->parameters(), $locale);
        $query = request()->getQueryString();

        return $query ? $url.'?'.$query : $url;
    }

    /**
     * Alternate URLs of the current page, for hreflang links.
     *
     * @return array<string, string>
     */
    public static function alternates(): array
    {
        $urls = [];

        foreach (self::codes() as $code) {
            $urls[$code] = self::switchUrl($code);
        }

        return $urls;
    }
}
