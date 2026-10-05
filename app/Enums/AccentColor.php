<?php

namespace App\Enums;

enum AccentColor: string
{
    case Violet = 'violet';
    case Lime = 'lime';
    case Night = 'night';
    case Lilac = 'lilac';
    case Ink = 'ink';
    case Mist = 'mist';

    public function label(): string
    {
        return match ($this) {
            self::Violet => 'Violet',
            self::Lime => 'Vert citron',
            self::Night => 'Bleu nuit',
            self::Lilac => 'Lilas',
            self::Ink => 'Noir',
            self::Mist => 'Gris',
        };
    }

    public function hex(): string
    {
        return match ($this) {
            self::Violet => '#6A1BF0',
            self::Lime => '#A6F20A',
            self::Night => '#0B1533',
            self::Lilac => '#DCCBFF',
            self::Ink => '#0E0E10',
            self::Mist => '#EFEEEA',
        };
    }

    /**
     * Whether text and inner frame on top of this color must be light.
     */
    public function isDark(): bool
    {
        return in_array($this, [self::Violet, self::Night, self::Ink], true);
    }
}
