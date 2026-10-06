<?php

namespace App\Enums;

enum ExperienceType: string
{
    case Job = 'job';
    case Education = 'education';

    public function label(): string
    {
        return match ($this) {
            self::Job => __('Expérience'),
            self::Education => __('Formation'),
        };
    }
}
