<?php

namespace App\Support;

/**
 * Helpers for list fields stored as one item per line.
 */
class Lines
{
    /**
     * @return list<string>
     */
    public static function split(?string $text): array
    {
        if ($text === null) {
            return [];
        }

        return array_values(array_filter(
            array_map(fn (string $line) => trim(ltrim(trim($line), '-•*')), preg_split('/\R/', $text) ?: []),
            fn (string $line) => $line !== '',
        ));
    }
}
