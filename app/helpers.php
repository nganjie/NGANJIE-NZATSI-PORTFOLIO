<?php

use App\Support\Localization;

if (! function_exists('localized_route')) {
    /**
     * URL of a public route in the current (or given) locale.
     */
    function localized_route(string $name, mixed $parameters = [], ?string $locale = null): string
    {
        return Localization::route($name, $parameters, $locale);
    }
}
